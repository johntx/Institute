<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Career;
use Illuminate\Routing\Route;
use Validator;

class CareerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->career = Career::find($route->getParameter('career'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $careers = Career::orderBy('id','DESC')->paginate(20);
        return view('admin/career.index',compact('careers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subjects = \Institute\Subject::orderBy('nombre','asc')->get();
        return view('admin/career.create',['subjects'=>$subjects, 'career'=>null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $career = Career::create($request->all());
        if (!empty($request['subjects'])){
            $career->subjects()->attach($request['subjects']);
        }
        Session::flash('success','Carrera registrada exitosamente');
        return Redirect::to('/admin/career');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/career.delete',['career'=>$this->career]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjects = \Institute\Subject::orderBy('nombre','asc')->get();
        return view('admin/career.edit',['career'=>$this->career,'subjects'=>$subjects]);
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
        $this->career->fill($request->all());
        $this->career->save();
        $this->career->subjects()->detach();
        if (!empty($request['subjects'])){
            $this->career->subjects()->attach($request['subjects']);
        }
        Session::flash('success','Carrera editada exitosamente');
        return Redirect::to('/admin/career');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->career->delete();
        Session::flash('success','Carrera borrada exitosamente');
        return Redirect::to('/admin/career');
    }
}
