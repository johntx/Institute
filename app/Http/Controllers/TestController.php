<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Test;
use Institute\Career;
use Illuminate\Routing\Route;
use Validator;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->test = Test::find($route->getParameter('test'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $careers = \Institute\Career::get();
        return view('admin/test.index',['careers'=>$careers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $careers = \Institute\Career::lists('nombre', 'id');
        $subjects = \Institute\Subject::lists('nombre', 'id');
        return view('admin/test.create',['careers'=>$careers,'subjects'=>$subjects]);
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
        Test::create($request->all());
        Session::flash('message','Asignatura registrado exitosamente');
        return Redirect::to('/admin/test');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/test.delete',['test'=>$this->test]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $career = \Institute\Career::find($id);
        return view('admin/test.edit',['test'=>$this->test,'career'=>$career]);
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
        $career = Career::find($request['career_id']);
        $career->tests->each(function ($test){$test->delete();});
        for ($i=0; $i < count($request['nombre']); $i++) {
            $test = new Test;
            $test->fill([
                'nombre' => strtoupper($request['nombre'][$i]),
                'subject_id' => $request['subject_id'][$i],
                'modulo' => $request['modulo'][$i],
                'career_id' => $request['career_id']
                ]);
            $test->save();
        }
        Session::flash('message','Registro Guardado Exitosamente');
        return Redirect::to('/admin/test');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->test->delete();
        Session::flash('message','Asignatura borrado exitosamente');
        return Redirect::to('/admin/test');
    }
}
