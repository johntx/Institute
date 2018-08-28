<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Subject;
use Illuminate\Routing\Route;
use Validator;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->subject = Subject::find($route->getParameter('subject'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::orderBy('id','DESC')->paginate(20);
        return view('admin/subject.index',compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $careers = \Institute\Career::lists('nombre', 'id');
        $peoples = \Institute\People::lists('nombre', 'id');
        return view('admin/subject.create',['careers'=>$careers,'peoples'=>$peoples]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['nombre']=strtoupper($request['nombre']);
        Subject::create($request->all());
        Session::flash('success','Asignatura registrado exitosamente');
        return Redirect::to('/admin/subject');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/subject.delete',['subject'=>$this->subject]);
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
        $peoples = \Institute\People::lists('nombre', 'id');
        return view('admin/subject.edit',['subject'=>$this->subject, 'careers'=>$careers,'peoples'=>$peoples]);
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
        $request['nombre']=strtoupper($request['nombre']);
        $this->subject->fill($request->all());
        $this->subject->save();
        Session::flash('success','Asignatura editado exitosamente');
        return Redirect::to('/admin/subject');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->subject->delete();
        Session::flash('success','Asignatura borrado exitosamente');
        return Redirect::to('/admin/subject');
    }
}
