<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Interested;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class InterestedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->interested = Interested::find($route->getParameter('interested'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interesteds = Interested::orderBy('id','DESC')->paginate(20);
        return view('admin/interested.index',compact('interesteds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $careers = \Institute\Career::lists('nombre', 'id');
        return view('admin/interested.create',['careers'=>$careers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['fecha']=\Carbon\Carbon::now();
        $request['user_id']=Auth::id();
        $request['nombre']=strtoupper($request['nombre']);
        Interested::create($request->all());
        Session::flash('success','Asignatura registrado exitosamente');
        return Redirect::to('/admin/interested');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/interested.delete',['interested'=>$this->interested]);
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
        return view('admin/interested.edit',['interested'=>$this->interested, 'careers'=>$careers]);
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
        $this->interested->fill($request->all());
        $this->interested->save();
        Session::flash('success','Asignatura editado exitosamente');
        return Redirect::to('/admin/interested');
    }

    public function interestedsend($id)
    {
        $interested = Interested::find($id);
        $interested->enviado = 'Si';
        $interested->save();
        return "guardado";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->interested->delete();
        Session::flash('success','Asignatura borrado exitosamente');
        return Redirect::to('/admin/interested');
    }
}
