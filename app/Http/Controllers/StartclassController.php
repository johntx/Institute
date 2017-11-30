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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $startclasses = Startclass::orderBy('id','DESC')->paginate(20);
      return view('admin/startclass.index',compact('startclasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $careers = \Institute\Career::lists('nombre', 'id');
      return view('admin/startclass.create',['careers'=>$careers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $career = \Institute\Career::find($request['career_id']);
      $fecha = date('Y-m-d',strtotime('+'.$career->duracion.' weeks', strtotime($request['fecha_inicio'])));
      
      $startclass = new Startclass();
      $startclass->fill([
      'fecha_inicio' => $request['fecha_inicio'],
      'fecha_fin' => $fecha,
      'career_id' => $request['career_id'],
      'estado' => $request['estado']
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
      $startclass->save();
      $startclass->groups()->saveMany($col);
      Session::flash('message','Inicio de Clases registrado exitosamente');
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
      $careers = \Institute\Career::lists('nombre', 'id');
      return view('admin/startclass.edit',['startclass'=>$this->startclass, 'careers'=>$careers]);
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
      $career = \Institute\Career::find($request['career_id']);
      $fecha = date('Y-m-d',strtotime('+'.$career->duracion.' weeks', strtotime($request['fecha_inicio'])));
      $this->startclass->fill([
        'fecha_inicio' => $request['fecha_inicio'],
        'fecha_fin' => $fecha,
        'career_id' => $request['career_id'],
        'estado' => $request['estado']
        ]);
      $this->startclass->save();
      Session::flash('message','Inicio de Clases editado exitosamente');
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
      Session::flash('message','Inicio de Clases borrado exitosamente');
      return Redirect::to('/admin/startclass');
    }
  }
