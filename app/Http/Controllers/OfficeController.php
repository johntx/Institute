<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Office;
use Illuminate\Routing\Route;
use Validator;

class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->office = Office::find($route->getParameter('office'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offices = Office::orderBy('id','DESC')->paginate(20);
        return view('admin/office.index',compact('offices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/office.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Office::create($request->all());
        Session::flash('message','Sucursal registrado exitosamente');
        return Redirect::to('/admin/office');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/office.delete',['office'=>$this->office]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin/office.edit',['office'=>$this->office]);
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
        $this->office->fill($request->all());
        $this->office->save();
        Session::flash('message','Sucursal editado exitosamente');
        return Redirect::to('/admin/office');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->office->delete();
        Session::flash('message','Sucursal borrado exitosamente');
        return Redirect::to('/admin/office');
    }
}
