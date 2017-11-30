<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Group;
use Illuminate\Routing\Route;
use Validator;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->group = Group::find($route->getParameter('group'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::orderBy('id','DESC')->paginate(20);
        return view('admin/group.index',compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $careers = \Institute\Career::lists('nombre', 'id');
        $startclasses = \Institute\Startclass::select('startclasses.*')
        ->where('startclasses.estado','!=','Cerrado')
        ->get();
        return view('admin/group.create',['careers'=>$careers, 'startclasses'=>$startclasses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Group::create($request->all());
        Session::flash('message','Grupo registrado exitosamente');
        return Redirect::to('/admin/group');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/group.delete',['group'=>$this->group]);
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
        ->where('startclasses.estado','!=','Cerrado')
        ->get();
        $careers = \Institute\Career::lists('nombre', 'id');
        return view('admin/group.edit',['group'=>$this->group, 'careers'=>$careers, 'startclasses'=>$startclasses]);
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
        $this->group->fill($request->all());
        $this->group->save();
        Session::flash('message','Grupo editado exitosamente');
        return Redirect::to('/admin/group');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->group->delete();
        Session::flash('message','Grupo borrado exitosamente');
        return Redirect::to('/admin/group');
    }
}
