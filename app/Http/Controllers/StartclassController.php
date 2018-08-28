<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Startclass;
use Institute\Group;
use Illuminate\Routing\Route;
use Validator;

class StartclassController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('admin',['only' => ['index','create','edit','show']]);
    $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
  }
  public function find(Route $route)
  {
    $this->startclass = Startclass::find($route->getParameter('startclass'));
  }

  public function getgroups(Request $request,$id)
  {
    /*$groups = \Institute\Group::groups($id);
    return $groups;*/
    if ($request->ajax()) {
      $groups = \Institute\Group::groups($id);
      return response()->json($groups);
    }
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $startclasses = Startclass::
      join('careers','startclasses.career_id','=','careers.id')
      ->select('startclasses.*')
      ->orderBy('fecha_inicio','DESC')->paginate(20);
      return view('admin/startclass.index',compact('startclasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $offices = \Institute\Office::lists('nombre', 'id');
      $careers = \Institute\Career::lists('nombre', 'id');
      return view('admin/startclass.create',['careers'=>$careers,'offices'=>$offices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $fecha_actual = \Carbon\Carbon::now()->format('Y-m-d');
      $fecha_1 = date('Y-m-d',strtotime('+'.$request['duracion'].' month', strtotime($request['fecha_inicio'])));
      $fecha_fin = date('Y-m-d',strtotime('-1 day', strtotime($fecha_1)));
      $estado = '';
      if ($fecha_actual<$request['fecha_inicio']) {
        $estado = 'Espera';
      } elseif($fecha_actual<$fecha_fin){
        $estado = 'Iniciado';
      } else {
        $estado = 'Cerrado';
      }
      $startclass = new Startclass();
      $startclass->fill([
        'fecha_inicio' => $request['fecha_inicio'],
        'fecha_fin' => $fecha_fin,
        'career_id' => $request['career_id'],
        'duracion' => $request['duracion'],
        'descripcion' => $request['descripcion'],
        'costo' => $request['costo'],
        'office_id' => $request['office_id'],
        'estado' => $estado
        ]);
      $col = collect();
      if (count($request['turno'])>0) {
        for ($i=0; $i < count($request['turno']); $i++) {
          $group = new Group;
          $group->turno = $request['turno'][$i];
          $group->estado = 'Vigente';
          $col->push($group);
        }
      }
      if ($request['otro']!='') {
          $group = new Group;
          $group->turno = $request['otro'];
          $group->estado = 'Vigente';
          $col->push($group);
      }
      $startclass->save();
      $startclass->groups()->saveMany($col);
      Session::flash('success','Inicio de Clases registrado exitosamente');
      return Redirect::to('/admin/startclass');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return view('admin/startclass.delete',['startclass'=>$this->startclass]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $offices = \Institute\Office::lists('nombre', 'id');
      $careers = \Institute\Career::lists('nombre', 'id');
      return view('admin/startclass.edit',['startclass'=>$this->startclass, 'careers'=>$careers, 'offices'=>$offices]);
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
      $this->startclass->fill([
        'fecha_inicio' => $request['fecha_inicio'],
        'fecha_fin' => $request['fecha_fin'],
        'duracion' => $request['duracion'],
        'descripcion' => $request['descripcion'],
        'costo' => $request['costo'],
        'career_id' => $request['career_id'],
        'office_id' => $request['office_id'],
        'estado' => $request['estado']
        ]);
      $this->startclass->save();
      Session::flash('success','Inicio de Clases editado exitosamente');
      return Redirect::to('/admin/startclass');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->startclass->delete();
      Session::flash('success','Inicio de Clases borrado exitosamente');
      return Redirect::to('/admin/startclass');
    }
  }
