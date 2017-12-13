<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\People;
use Institute\User;
use Illuminate\Routing\Route;
use Validator;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->teacher = People::find($route->getParameter('teacher'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = People::join('users','peoples.id','=','users.id')
        ->join('roles','users.role_id','=','roles.id')
        ->select('peoples.*')
        ->where('roles.code','DOC')
        ->orderBy('users.id','DESC')
        ->paginate(20);
        return view('admin/teacher.index',compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $offices = \Institute\Office::lists('nombre', 'id');
        return view('admin/teacher.create',['offices'=>$offices]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ci' => 'required|unique:peoples'
            ]);

        if ($validator->fails()) {
            return redirect('/admin/teacher/create')
            ->withErrors($validator)
            ->withInput();
        }
        $user = new User;
        $user->fill([
            'user' => $request['ci'],
            'password' => $request['ci'],
            'role_id' => 4
            ]);
        $user->save();
        $cien = 'CIEN-'.$user->id;
        $user->user = $cien;
        $people = new People;
        $people->fill([
            'ci' => $request['ci'],
            'nombre' => $request['nombre'],
            'paterno' => $request['paterno'],
            'materno' => $request['materno'],
            'fecha_ingreso' => $request['fecha_ingreso'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'nacionalidad' => $request['nacionalidad'],
            'direccion' => $request['direccion'],
            'telefono' => $request['telefono'],
            'office_id' => $request['office_id']
            ]);
        $user->save();
        $user->people()->save($people);

        People::create($request->all());
        Session::flash('message','Docente registrado exitosamente');
        return Redirect::to('/admin/teacher');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/teacher.delete',['teacher'=>$this->teacher]);
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
        return view('admin/teacher.edit',['teacher'=>$this->teacher,'offices'=>$offices]);
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
        $this->teacher->fill($request->all());
        $this->teacher->save();
        Session::flash('message','Docente editado exitosamente');
        return Redirect::to('/admin/teacher');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->teacher->delete();
        Session::flash('message','Docente borrado exitosamente');
        return Redirect::to('/admin/teacher');
    }
}
