<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\People;
use Institute\User;
use Institute\Inscription;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class InscriptionController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('admin',['only' => ['index','create','edit','show']]);
    $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
  }
  public function find(Route $route)
  {
    $this->inscription = Inscription::find($route->getParameter('inscription'));
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $peoples = People::
      join('inscriptions','peoples.id','=','inscriptions.people_id')
      ->select('peoples.*')
      ->distinct()
      ->get();
      return view('admin/inscription.index',['peoples'=>$peoples]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    $extras = \Institute\Extra::get();
      $students = People::
      join('inscriptions','peoples.id','=','inscriptions.people_id')
      ->select('peoples.*')
      ->orderBy('peoples.id','DESC')
      ->distinct()
      ->get();
      $startclasses = \Institute\Startclass::
      join('careers','startclasses.career_id','=','careers.id')
      ->select('startclasses.*')
      ->where('startclasses.estado','!=','Cerrado')
      ->orderBy('startclasses.fecha_inicio','DESC')
      ->get();
      return view('admin/inscription.create',['startclasses'=>$startclasses,'students'=>$students,'extras'=>$extras]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if (Auth::user()->role->code=='ROOT') {
        Session::flash('error',"Este usuario no puede realizar esta función");
        return Redirect::to('admin/inscription/create');
      }
      if ($request['user_id']==null) {
        Session::flash('alert',"Seleccione un Estudiante");
        return Redirect::to('admin/inscription/create');
      }
      $group=\Institute\Group::find($request['group_id']);
      if ($request['abono'] > $request['total']) {
        Session::flash('error',"Monto superior al total");
        return Redirect::to('admin/inscription/create');
      }
      if ($request['abono'] > $request['monto'] && $request['abono'] != $request['total']) {
        Session::flash('error',"Monto superior al pago mensual");
        return Redirect::to('admin/inscription/create');
      }
      $inscription = new Inscription;
      if ($request['abono'] == $request['total']) {
        $colegiatura = 'Pagado';
      }
      if ($request['abono'] < $request['total']) {
        $colegiatura = 'Debe';
      }
      $people= People::find($request['user_id']);
      $people->observacion = $request['observacion'];
      $people->save();
      $startclass = \Institute\Startclass::find($request['startclass_id']);
      $inscription->fill([
        'estado' => 'Inscrito',
        'people_id' => $people->id,
        'fecha_ingreso' => $request['fecha_ingreso'],
        'monto' => $request['monto'],
        'abono' => $request['abono'],
        'total' => $request['total'],
        'colegiatura' => $colegiatura,
        'group_id' => $request['group_id'],
        'user_id' => Auth::user()->id
        ]);
      $inscription->save();

      if ($request['abono'] == $request['total']) {
        $payment = new \Institute\Payment;
        $payment->fill([
          'fecha_pagar' => $request['fecha_ingreso'],
          'fecha_pago' => $request['fecha_ingreso'],
          'estado' => 'Pagado',
          'observacion' => 'Pagado al Contado',
          'abono' => $request['abono'],
          'saldo' => $request['abono'],
          'inscription_id' => $inscription->id,
          'user_id' => Auth::user()->id
          ]);
        $payment->save();
      } else {
        $saldo = 0;
        $fecha_insert = $request['fecha_ingreso'];
        $fecha_start_class = new \Carbon\Carbon($group->startclass->fecha_inicio);
        if($fecha_insert > $fecha_start_class){
          $fecha_inicio = $fecha_insert;
        }else{
          $fecha_inicio = $group->startclass->fecha_inicio;
        }
        if ($request['abono'] < $request['monto']) {
          $saldo = $request['monto']-$request['abono'];
          $fecha_pagar = date('Y-m-d',strtotime('+1 week', strtotime($fecha_inicio)));
        }
        if ($request['abono'] == $request['monto']) {
          $fecha_pagar = date('Y-m-d',strtotime('+1 month', strtotime($fecha_inicio)));
          $saldo = $request['monto'];
          if ($saldo > ($inscription->total - $inscription->abono)) {
            $saldo = $inscription->total - $inscription->abono;
          }
        }
        $payment = new \Institute\Payment;
        $payment->fill([
          'fecha_pagar' => $group->startclass->fecha_inicio,
          'fecha_pago' => $request['fecha_ingreso'],
          'estado' => 'Pagado',
          'abono' => $request['abono'],
          'saldo' => $request['monto'],
          'inscription_id' => $inscription->id,
          'user_id' => Auth::user()->id
          ]);
        $payment->save();
        $payment2 = new \Institute\Payment;
        $payment2->fill([
          'fecha_pagar' => $fecha_pagar,
          'estado' => 'Pendiente',
          'abono' => 0,
          'saldo' => $saldo,
          'inscription_id' => $inscription->id
          ]);
        $payment2->save();
      }
    Session::flash('pdf','admin/payment/pdf/'.$payment->id);
    return Redirect::to('admin/inscription/create');
  }

  public function show($id)
  {
    return view('admin/inscription.delete',['inscription'=>$this->inscription]);
  }

  public function destroy($id)
  {
    $people = \Institute\People::find($this->inscription->people_id);
    if (count($people->inscriptions)>1) {
      $this->inscription->payments->each(function($payment){
        $payment->delete();
      });
      $this->inscription->delete();
      Session::flash('success','Inscripción Eliminada exitosamente');
    } else {
      Session::flash('error','No se puede eliminar la inscripción de este estudiante');
    }
    return Redirect::to('/admin/student/'.$this->inscription->people_id.'/edit');
  }
}
