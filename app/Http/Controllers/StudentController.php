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
use Auth;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->student = People::find($route->getParameter('student'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = People::join('users','peoples.id','=','users.id')
        ->join('roles','users.role_id','=','roles.id')
        ->select('peoples.*')
        ->where('roles.code','EST')
        ->orderBy('users.id','DESC')
        ->paginate(20);
        return view('admin/student.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $careers = \Institute\Career::join('startclasses','careers.id','=','startclasses.career_id')
        ->where('startclasses.estado','!=','Cerrado')
        ->get();
        return view('admin/student.create',['careers'=>$careers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['ci']=strtoupper($request['ci']);
        $validator = Validator::make($request->all(), [
            'ci' => 'required|unique:peoples'
            ]);

        if ($validator->fails()) {
            return redirect('/admin/student/create')
            ->withErrors($validator)
            ->withInput();
        }
        if (Auth::user()->role->code=='ROOT' || Auth::user()->role->code=='ADM') {
            Session::flash('message','Este usuario no puede realizar esta función');
            return Redirect::to('/admin/student');
        }
        User::create([
            'user' => $request['ci'],
            'password' => $request['ci'],
            'role_id' => 3
            ]);
        $user = User::where('user', $request['ci'])->first();
        $cien = 'CIEN-'.$user->id;
        $user->user = $cien;
        $user->save();
        People::create([
            'id' => $user->id,
            'ci' => $request['ci'],
            'nombre' => $request['nombre'],
            'paterno' => $request['paterno'],
            'materno' => $request['materno'],
            'fecha_ingreso' => $request['fecha_ingreso'],
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'nacionalidad' => $request['nacionalidad'],
            'direccion' => $request['direccion'],
            'telefono' => $request['telefono'],
            'office_id' => Auth::user()->people->office_id
            ]);
        Session::flash('message','Estudiante registrado exitosamente');
        return Redirect::to('/admin/student');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/student.delete',['student'=>$this->student]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin/student.edit',['student'=>$this->student]);
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
        $this->student->fill($request->all());
        $this->student->save();
        Session::flash('message','Estudiante editado exitosamente');
        return Redirect::to('/admin/student');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->student->delete();
        Session::flash('message','Estudiante borrado exitosamente');
        return Redirect::to('/admin/student');
    }
}
