<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Payment;
use Institute\People;
use Institute\Numeroaletras;
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
  public function pdf($id)
  {
    $payment = Payment::find($id);
    $suma = Numeroaletras::convertir($payment->abono);
    $view =  view('pdf/PDFRecibo', ['payment'=>$payment, 'suma'=>$suma])->render();
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view)->setPaper('a5', 'landscape');
    return $pdf->stream('Recibo '.$payment->inscription->people->nombrecompleto().'.pdf');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $payments = Payment::join('users','payments.user_id','=','users.id')
    ->join('inscriptions','payments.inscription_id','=','inscriptions.id')
    ->select('payments.*','users.user')
    ->where('payments.estado', 'LIKE','Pagado%')
    ->orderBy('payments.id','DESC')->paginate(20);
    return view('admin/payment.index',compact('payments'));
  }

  public function mypayments()
  {
    $payments = \Institute\Payment::where('estado', 'LIKE','Pagado%')
    ->where('user_id',Auth::user()->id)
    ->orderBy('created_at','desc')
    ->paginate(20);
    return view('admin/payment.mypayments',['payments'=>$payments]);
  }

  public function recibir(Request $request)
  {
    for ($i=0; $i < count($request['recibido']); $i++) {
      $payment = \Institute\Payment::find($request['recibido'][$i]);
      $payment->recibido = true;
      $payment->save();
    }
    for ($i=0; $i < count($request['venta']); $i++) {
      $order = \Institute\Order::find($request['venta'][$i]);
      $order->recibido = true;
      $order->save();
    }
    return Redirect::to('/admin/report/incomeByEmployee');
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
    ->orderBy('peoples.id','DESC')
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
    $descuento=0;
    if ($request['descuento']!=null) {
      $descuento=$request['descuento'];
    }
    if ($request['user_id']==null) {
      Session::flash('error',"Seleccione un estudiante");
      return Redirect::to('admin/payment/create');
    }
    $inscription = \Institute\Inscription::find($request['inscription_id']);
    if ($inscription->colegiatura == 'Pagado') {
      Session::flash('error',"El cliente ya tiene la colegiatura pagada");
      return Redirect::to('admin/payment/create');
    }
    $lastpayment = \Institute\Payment::where('inscription_id',$request['inscription_id'])
    ->where('estado','Pendiente')
    ->first();
    $deuda = $inscription->total - $inscription->abono;
    if ($request['abono'] == $deuda) {
      $lastpayment->fill([
        'fecha_pago' => $request['fecha_pago'],
        'estado' => 'Pagado',
        'created_at' => \Carbon\Carbon::now(),
        'observacion' => $request['observacion'],
        'abono' => $request['abono'],
        'descuento' => $descuento,
        'saldo' => $request['abono'],
        'user_id' => Auth::user()->id
        ]);
      $lastpayment->save();
      $inscription->fill([
        'abono' => $inscription->total,
        'colegiatura' => 'Pagado'
        ]);
      $inscription->save();
      Session::flash('pdf','admin/payment/pdf/'.$lastpayment->id);
      return Redirect::to('admin/payment/create');
    } elseif ($request['abono']+$descuento > $lastpayment->saldo) {
      Session::flash('error',"Monto superior al saldo");
      return Redirect::to('admin/payment/create');
    } else {
      $PaymentSaldo = $lastpayment->saldo - $request['abono'] - $descuento;
      $lastpayment->fill([
        'fecha_pago' => $request['fecha_pago'],
        'estado' => 'Pagado',
        'created_at' => \Carbon\Carbon::now(),
        'observacion' => $request['observacion'],
        'abono' => $request['abono'],
        'descuento' => $descuento,
        'user_id' => Auth::user()->id
        ]);
      $lastpayment->save();
      $Inscriptionestado = 'Debe';
      if ($inscription->abono + $request['abono'] + $descuento == $inscription->total) {
        $Inscriptionestado = 'Pagado';
      }
      $inscription->fill([
        'abono' => $inscription->abono + $request['abono'] + $descuento,
        'colegiatura' => $Inscriptionestado
        ]);
      $inscription->save();
      if ($inscription->abono < $inscription->total) {
        if ($PaymentSaldo == 0) {
          $mes = round($inscription->abono / $inscription->monto);
          $payment = new \Institute\Payment;
          if ($inscription->group->startclass->fecha_inicio > $inscription->fecha_ingreso) {
            $fecha_pagar = date('Y-m-d',strtotime('+'.$mes.' month', strtotime($inscription->group->startclass->fecha_inicio)));
          } else {
            $fecha_pagar = date('Y-m-d',strtotime('+'.$mes.' month', strtotime($inscription->fecha_ingreso)));
          }
          $saldo = $inscription->monto;
          if ($saldo > ($inscription->total - $inscription->abono)) {
            $saldo = $inscription->total - $inscription->abono;
          }
          $payment->fill([
            'fecha_pagar' => $fecha_pagar,
            'estado' => 'Pendiente',
            'abono' => 0,
            'saldo' => $saldo,
            'inscription_id' => $request['inscription_id']
            ]);
          $payment->save();
        } else {
          $monto = $inscription->monto;
          $abono = $request['abono'];
          $dias = $abono*30/$monto;
          $dias = round($dias);
          $fecha_pagar = date('Y-m-d',strtotime('+'.$dias.' day', strtotime($lastpayment->fecha_pagar)));
          $payment = new \Institute\Payment;
          $payment->fill([
            'fecha_pagar' => $fecha_pagar,
            'estado' => 'Pendiente',
            'abono' => 0,
            'saldo' => $PaymentSaldo,
            'inscription_id' => $request['inscription_id']
            ]);
          $payment->save();
        }
      }
      Session::flash('pdf','admin/payment/pdf/'.$lastpayment->id);
      return Redirect::to('admin/payment/create');
    }
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
    return view('admin/payment.edit',['payment'=>$this->payment]);
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
    $this->payment->fill($request->all());
    $this->payment->save();
    Session::flash('success','Pago editado exitosamente');
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
          'observacion' => null,
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
      if ($this->payment->abono < $this->payment->saldo) {
        $lastpayment = \Institute\Payment::where('inscription_id',$this->payment->inscription_id)
        ->where('estado','Pendiente')
        ->first();
        $lastpayment->saldo += $this->payment->abono;
        $lastpayment->save();
      }
      $inscription->abono = $inscription->abono - $this->payment->abono;
      $inscription->save();
      $this->payment->delete();
    }
    Session::flash('success','Pago borrado exitosamente');
    return Redirect::to('/admin/payment');
  }
}
