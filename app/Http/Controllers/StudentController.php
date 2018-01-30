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
      ->leftjoin('inscriptions','users.id','=','inscriptions.user_id')
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
      $startclasses = \Institute\Startclass::
      select('startclasses.*')
      ->join('careers','startclasses.career_id','=','careers.id')
      ->where('startclasses.estado','!=','Cerrado')
      ->orderBy('startclasses.fecha_inicio','DESC')
      ->get();
      return view('admin/student.create',['startclasses'=>$startclasses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if ($request->ajax()) {
        if (Auth::user()->role->code=='ROOT') {
          header('HTTP/1.1 500 Este usuario no puede realizar esta función');
          header('Content-Type: application/json; charset=UTF-8');
          die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
        $group=\Institute\Group::find($request['group_id']);
        if ($request['abono'] > $request['total']) {
          header('HTTP/1.1 500 Monto superior al total');
          header('Content-Type: application/json; charset=UTF-8');
          die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
        if ($request['abono'] > $request['monto'] && $request['abono'] != $request['total']) {
          header('HTTP/1.1 500 Monto superior al pago mensual');
          header('Content-Type: application/json; charset=UTF-8');
          die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
        }
        $request['nombre']=strtoupper($request['nombre']);
        $request['paterno']=strtoupper($request['paterno']);
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
        $cien = 'CIEN-'.$user->id;
        $user->user = $cien;
        $people = new People;
        $people->fill([
          'ci' => $request['ci'],
          'nombre' => $request['nombre'],
          'paterno' => $request['paterno'],
          'fecha_nacimiento' => $request['fecha_nacimiento'],
          'direccion' => $request['direccion'],
          'telefono' => $request['telefono'],
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
          'career_id' => $startclass->career->id,
          'group_id' => $request['group_id'],
          'user_id' => Auth::user()->id
          ]);
        $user->save();
        $user->people()->save($people);
        $inscription->save();

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
        Session::flash('message','Estudiante registrado exitosamente');
        return $payment->id;
        //return Redirect::to('/admin/student');
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
      $startclasses = \Institute\Startclass::
      where('startclasses.estado','!=','Cerrado')
      ->orderBy('startclasses.fecha_inicio','DESC')
      ->get();
      return view('admin/student.edit',['student'=>$this->student, 'startclasses'=>$startclasses]);
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
      $this->student->fill([
        'ci' => $request['ci'],
        'nombre' => $request['nombre'],
        'paterno' => $request['paterno'],
        'fecha_nacimiento' => $request['fecha_nacimiento'],
        'direccion' => $request['direccion'],
        'telefono' => $request['telefono']
        ]);

      $col = collect();
      for ($i=0; $i < count($request['inscription_id']); $i++) {
        $inscription = new \Institute\Inscription;
        $inscription->id = $request['inscription_id'][$i];
        $inscription->group_id = $request['group_id'][$i];
        $inscription->estado = $request['estado'][$i];
        $inscription->fecha_ingreso = $request['fecha_ingreso'][$i];
        $inscription->career_id = $request['career_id'][$i];
        $inscription->monto = $request['monto'][$i];
        $inscription->abono = $request['abono'][$i];
        $inscription->total = $request['total'][$i];
        $inscription->colegiatura = $request['colegiatura'][$i];
        $inscription->user_id = Auth::user()->id;
        $col->push($inscription);
      }
      $this->student->save();
      $this->student->inscriptions()->delete();
      $this->student->inscriptions()->saveMany($col);

      Session::flash('message','Estudiante editado exitosamente');
      return Redirect::to('/admin/student');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->student->inscriptions->each(function($inscription)
      {
        $inscription->payments->each(function($payment){
          $payment->delete();
        });
        $inscription->delete();
      });
      $this->student->delete();
      $this->student->user->delete();
      Session::flash('message','Estudiante borrado exitosamente');
      return Redirect::to('/admin/student');
    }
  }
