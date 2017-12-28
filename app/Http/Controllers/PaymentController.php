<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Payment;
use Institute\People;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->payment = Payment::find($route->getParameter('payment'));
    }

    public function getpayments(Request $request,$id)
    {
        return Payment::payments($id);
        if ($request->ajax()) {
            $payments = Payment::payments($id);
            return response()->json($payments);
        }
    }
    public function getinscriptions(Request $request,$id)
    {
        return \Institute\Inscription::inscriptions($id);
        if ($request->ajax()) {
            $inscriptions = \Institute\Inscription::inscriptions($id);
            return response()->json($inscriptions);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::join('users','payments.user_id','=','users.id')
        ->select('payments.*','users.user')
        ->orderBy('payments.id','DESC')->paginate(20);
        return view('admin/payment.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = People::
        join('inscriptions','peoples.id','=','inscriptions.people_id')
        ->select('peoples.*')
        ->where('inscriptions.estado','Inscrito')
        ->distinct()
        ->get();
        return view('admin/payment.create',['students'=>$students]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inscription = \Institute\Inscription::find($request['inscription_id']);
        if ($inscription->colegiatura == 'Pagado') {
            return redirect('admin/payment/create')
            ->withErrors('El cliente ya tiene la colegiatura pagada');
        }
        $lastpayment = \Institute\Payment::where('inscription_id',$request['inscription_id'])
        ->where('estado','Pendiente')
        ->first();
        if ($request['abono'] > $lastpayment->saldo) {
            return redirect('admin/payment/create')
            ->withErrors('Monto superior al saldo');
        }

        $PaymentSaldo = $lastpayment->saldo - $request['abono'];
        $lastpayment->fill([
            'fecha_pago' => $request['fecha_pago'],
            'estado' => 'Pagado',
            'observacion' => $request['observacion'],
            'abono' => $request['abono']
            ]);
        $lastpayment->save();

        $Inscriptionestado = 'Debe';
        if ($inscription->abono + $request['abono'] == $inscription->total) {
            $Inscriptionestado = 'Pagado';
        }
        $inscription->fill([
            'abono' => $inscription->abono + $request['abono'],
            'colegiatura' => $Inscriptionestado
            ]);
        $inscription->save();

        if ($inscription->abono < $inscription->total) {
            if ($PaymentSaldo == 0) {
                $mes = $inscription->abono / $inscription->monto;
                $payment = new \Institute\Payment;
                $fecha_pagar = date('Y-m-d',strtotime('+'.$mes.' month', strtotime($inscription->group->startclass->fecha_inicio)));
                $saldo = $request['monto'];
                $payment->fill([
                    'fecha_pagar' => $fecha_pagar,
                    'estado' => 'Pendiente',
                    'abono' => 0,
                    'saldo' => $inscription->monto,
                    'inscription_id' => $request['inscription_id'],
                    'user_id' => Auth::user()->id
                    ]);
                $payment->save();
            } else {
                $fecha_pagar = $lastpayment->fecha_pagar;
                if ($lastpayment->saldo == $inscription->monto) {
                    $fecha_pagar = date('Y-m-d',strtotime('+1 week', strtotime($lastpayment->fecha_pagar)));
                }
                $payment = new \Institute\Payment;
                $payment->fill([
                    'fecha_pagar' => $fecha_pagar,
                    'estado' => 'Pendiente',
                    'abono' => 0,
                    'saldo' => $PaymentSaldo,
                    'inscription_id' => $request['inscription_id'],
                    'user_id' => Auth::user()->id
                    ]);
                $payment->save();
            }
        }
        Session::flash('message','Pago registrado exitosamente');
        return Redirect::to('admin/payment/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/payment.delete',['payment'=>$this->payment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $startclasses = \Institute\Startclass::select('startclasses.*')
        ->orderBy('fecha_inicio','DESC')
        ->get();
        $careers = \Institute\Career::lists('nombre', 'id');
        return view('admin/payment.edit',['payment'=>$this->payment, 'careers'=>$careers, 'startclasses'=>$startclasses]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $fecha_actual = \Carbon\Carbon::now()->format('Y-m-d');
        $startclass = \Institute\Startclass::find($request['startclass_id']);

        if ($fecha_actual<=$startclass->fecha_fin) {
            $request['estado'] = 'Vigente';
        } else {
            $request['estado'] = 'Culminado';
        }
        $this->payment->fill($request->all());
        $this->payment->save();
        Session::flash('message','Pago editado exitosamente');
        return Redirect::to('/admin/payment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inscription = \Institute\Inscription::find($this->payment->inscription_id);
        if ($inscription->abono == $inscription->total) {
            /*Si pago toda la colegiatura en la inscripcion*/
            if ($this->payment->abono == $inscription->total) {
                $this->payment->fill([
                    'abono' => 0,
                    'saldo' => $inscription->monto,
                    'estado' => 'Pendiente',
                    'fecha_pago' => null
                    ]);
                $inscription->abono = 0;
                $inscription->colegiatura = 'Debe';

                $this->payment->save();
                $inscription->save();
            } else {
                $payment2 = new \Institute\Payment;
                $payment2->fill([
                    'fecha_pagar' => \Carbon\Carbon::now(),
                    'estado' => 'Pendiente',
                    'abono' => 0,
                    'saldo' => $this->payment->abono,
                    'inscription_id' => $inscription->id,
                    'user_id' => Auth::user()->id
                    ]);
                $payment2->save();
                $inscription->abono = $inscription->abono - $this->payment->abono;
                $inscription->colegiatura = 'Debe';
                $inscription->save();
                $this->payment->delete();
            }
        } else {
            $inscription->abono = $inscription->abono - $this->payment->abono;
            $inscription->save();
            $this->payment->delete();
        }
        Session::flash('message','Pago borrado exitosamente');
        return Redirect::to('/admin/payment');
    }
}
