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
use DB;

class StudentController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('admin',['only' => ['index','create','edit','show']]);
    $this->beforeFilter('@find',['only' => ['edit','update','destroy','show','search']]);
  }
  public function find(Route $route)
  {
    $this->student = People::find($route->getParameter('student'));
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $students = People::join('users','peoples.id','=','users.id')
    ->join('roles','users.role_id','=','roles.id')
    ->join('inscriptions','peoples.id','=','inscriptions.people_id')
    ->select('peoples.*')
    ->where('roles.code','EST')
    ->where('peoples.office_id',Auth::user()->people->office_id)
    ->orderBy('users.id','DESC')
    ->paginate(20);
    return view('admin/student.index',compact('students'));
  }

  /*DB::raw('CONCAT(peoples.nombre, peoples.paterno) AS fullname')*/
  public function getpeople(Request $request,$name)
  {
    if ($request->ajax()) {
      $people = People::join('users','peoples.id','=','users.id')
      ->join('roles','users.role_id','=','roles.id')
      ->select('peoples.*',DB::raw('CONCAT(peoples.nombre, " ", peoples.paterno) AS fullname'))
      ->where('roles.code','EST')
      ->whereRaw('CONCAT(peoples.nombre," ", peoples.paterno) LIKE ?', ['%'.$name.'%'])
      ->orWhere('peoples.telefono','like',$name.'%')
      ->get();
      return response()->json($people);
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    $extras = \Institute\Extra::get();
    $startclasses = \Institute\Startclass::
    select('startclasses.*')
    ->join('careers','startclasses.career_id','=','careers.id')
    ->where('startclasses.estado','!=','Cerrado')
    ->orderBy('startclasses.fecha_inicio','DESC')
    ->get();
    return view('admin/student.create',['startclasses'=>$startclasses,'extras'=>$extras]);
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
      return Redirect::to('admin/student/create');
    }
    $group=\Institute\Group::find($request['group_id']);
    if ($request['abono'] > $request['total']) {
      Session::flash('error',"Monto superior al total");
      return Redirect::to('admin/student/create');
    }
    if ($request['abono'] > $request['monto'] && $request['abono'] != $request['total']) {
      Session::flash('error',"Monto superior al pago mensual");
      return Redirect::to('admin/student/create');
    }
    $request['nombre']=strtoupper($request['nombre']);
    $request['paterno']=strtoupper($request['paterno']);
    $request['carrera']=strtoupper($request['carrera']);
    $user = new User;
    if ($request['ci'] != null) {
      $user->fill([
        'user' => $request['ci'],
        'password' => $request['ci'],
        'role_id' => 3
        ]);
    } else {
      $user->fill([
        'user' => 'C1EN',
        'password' => 'C1EN',
        'role_id' => 3
        ]);
    }
    $user->save();
    $cien = 'CIEN'.$user->id;
    $user->user = $cien;
    $people = new People;
    $people->fill([
      'ci' => $request['ci'],
      'nombre' => $request['nombre'],
      'paterno' => $request['paterno'],
      'observacion' => $request['observacion'],
      'fecha_nacimiento' => $request['fecha_nacimiento'],
      'direccion' => $request['direccion'],
      'telefono' => $request['telefono'],
      'telefono2' => $request['telefono2'],
      'carrera' => $request['carrera'],
      'encuesta' => $request['encuesta'],
      'office_id' => Auth::user()->people->office_id
      ]);
    $inscription = new Inscription;
    if ($request['abono'] == $request['total']) {
      $colegiatura = 'Pagado';
    }
    if ($request['abono'] < $request['total']) {
      $colegiatura = 'Debe';
    }
    $startclass = \Institute\Startclass::find($request['startclass_id']);
    $inscription->fill([
      'estado' => 'Inscrito',
      'fecha_ingreso' => $request['fecha_ingreso'],
      'people_id' => $user->id,
      'monto' => $request['monto'],
      'abono' => $request['abono'],
      'total' => $request['total'],
      'colegiatura' => $colegiatura,
      'group_id' => $request['group_id'],
      'user_id' => Auth::user()->id
      ]);
    $user->save();
    $user->people()->save($people);
    $inscription->save();
    if (!empty($request['extras'])){
      $inscription->extras()->attach($request['extras']);
    }

    if ($request['abono'] == $request['total']) {
      $payment = new \Institute\Payment;
      $payment->fill([
        'fecha_pagar' => $request['fecha_ingreso'],
        'fecha_pago' => $request['fecha_ingreso'],
        'estado' => 'Pagado',
        'abono' => $request['abono'],
        'saldo' => $request['abono'],
        'observacion' => 'Colegiatura completa pagada al contado',
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
        $monto = $inscription->monto;
        $abono = $request['abono'];
        $dias = $abono*30/$monto;
        $dias = round($dias);
        $fecha_pagar = date('Y-m-d',strtotime('+'.$dias.' day', strtotime($fecha_inicio)));
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
    Session::put('inscriptions',\Institute\Inscription::distinct('people_id')->get());
    Session::flash('pdf','admin/payment/pdf/'.$payment->id);
    return Redirect::to('admin/student/create');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return view('admin/student.delete',['student'=>$this->student]);
  }

  public function search($id)
  {
    $student = People::find($id);
    return view('admin/student.search',['student'=>$student]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $extras = \Institute\Extra::all();
    $startclasses = \Institute\Startclass::
    where('startclasses.estado','!=','Cerrado')
    ->orderBy('startclasses.fecha_inicio','DESC')
    ->get();
    return view('admin/student.edit',['student'=>$this->student, 'startclasses'=>$startclasses, 'extras'=>$extras]);
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
    if ($request['ci'] != $this->student->ci) {
      $user = User::find($this->student->id);
      $user->fill([
        'password' => $request['ci']
        ]);
      $user->save();
    }
    $request['nombre']=strtoupper($request['nombre']);
    $request['paterno']=strtoupper($request['paterno']);
    $request['carrera']=strtoupper($request['carrera']);
    $this->student->fill([
      'ci' => $request['ci'],
      'nombre' => $request['nombre'],
      'paterno' => $request['paterno'],
      'fecha_nacimiento' => $request['fecha_nacimiento'],
      'direccion' => $request['direccion'],
      'telefono2' => $request['telefono2'],
      'observacion' => $request['observacion'],
      'carrera' => $request['carrera'],
      'encuesta' => $request['encuesta'],
      'telefono' => $request['telefono']
      ]);
    $this->student->save();
    for ($i=0; $i < count($request['inscription_id']); $i++) {
      $inscription = Inscription::find($request['inscription_id'][$i]);
      if ($request['total'][$i] < $inscription->abono) {
        $request['total'][$i]=$inscription->total;
      }
      if ($inscription->abono == $inscription->total && $inscription->colegiatura=='Pagado') {
        if ($request['total'][$i] > $inscription->abono) {
          $payment = new \Institute\Payment;
          $payment->fill([
            'fecha_pagar' => \Carbon\Carbon::now(),
            'estado' => 'Pendiente',
            'abono' => 0,
            'saldo' => $request['total'][$i]-$inscription->abono,
            'inscription_id' => $inscription->id
            ]);
          $payment->save();
        }
      }
      if ($inscription->colegiatura == 'Debe') {
        $lastpayment = \Institute\Payment::where('inscription_id',$inscription->id)
        ->where('estado','Pendiente')
        ->first();
        if ($request['monto'][$i]!=$inscription->monto && $lastpayment->saldo==$inscription->monto) {
          $lastpayment->saldo = $request['monto'][$i];
          $lastpayment->save();
        }
      }
      $inscription->fill([
        'group_id' => $request['group_id'][$i],
        'estado' => $request['estado'][$i],
        'fecha_ingreso' => $request['fecha_ingreso'][$i],
        'monto' => $request['monto'][$i],
        'total' => $request['total'][$i],
        'colegiatura' => $request['colegiatura'][$i],
        'user_id' => Auth::user()->id
        ]);
      $inscription->save();
      $inscription->extras()->detach();
      if (!empty($request['extras'])){
        $inscription->extras()->attach($request['extras']);
      }
    }
    Session::flash('success','Estudiante editado exitosamente');
    return Redirect::to('/admin/student/search/'.$this->student->id);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $this->student->inscriptions->each(function($inscription){
      $inscription->payments->each(function($payment){
        $payment->delete();
      });
      $inscription->delete();
    });
    $this->student->delete();
    $this->student->user->delete();
    Session::flash('success','Estudiante borrado exitosamente');
    return Redirect::to('/admin/student');
  }
}
