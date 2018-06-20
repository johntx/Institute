<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Classroom;
use Illuminate\Routing\Route;
use Validator;

class ClassroomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->classroom = Classroom::find($route->getParameter('classroom'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classrooms = Classroom::orderBy('id','DESC')->paginate(20);
        return view('admin/classroom.index',compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $offices = \Institute\Office::lists('nombre', 'id');
        return view('admin/classroom.create',['offices'=>$offices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['area']=strtoupper($request['area']);
        $request['aula']=strtoupper($request['aula']);
        $request['piso']=strtoupper($request['piso']);
        Classroom::create($request->all());
        Session::flash('message','Aula registrado exitosamente');
        return Redirect::to('/admin/classroom');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/classroom.delete',['classroom'=>$this->classroom]);
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
        return view('admin/classroom.edit',['classroom'=>$this->classroom,'offices'=>$offices]);
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
        $request['area']=strtoupper($request['area']);
        $request['aula']=strtoupper($request['aula']);
        $request['piso']=strtoupper($request['piso']);
        $this->classroom->fill($request->all());
        $this->classroom->save();
        Session::flash('message','Aula editada exitosamente');
        return Redirect::to('/admin/classroom');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->classroom->delete();
        Session::flash('message','Aula borrada exitosamente');
        return Redirect::to('/admin/classroom');
    }
}
