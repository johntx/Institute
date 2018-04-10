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
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show','horario']]);
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
        $biometrics = \Institute\Biometric::lists('nombre', 'id');
        $subjects = \Institute\Subject::orderBy('nombre','asc')->get();
        $offices = \Institute\Office::lists('nombre', 'id');
        return view('admin/teacher.create',['biometrics'=>$biometrics, 'offices'=>$offices, 'subjects'=>$subjects, 'teacher'=>null]);
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
            'telefono' => $request['telefono'],
            'office_id' => $request['office_id']
            ]);
        $user->save();
        $user->people()->save($people);
        if (!empty($request['subjects'])){
            $people->subjects()->attach($request['subjects']);
        }
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

    public function horario($id)
    {
        $semana = array("hora","lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $horario = array('08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00');
        return view('admin/teacher.horario',['te'=>$this->teacher,'semana'=>$semana,'horario'=>$horario]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $biometrics = \Institute\Biometric::lists('nombre', 'id');
        $subjects = \Institute\Subject::orderBy('nombre','asc')->get();
        $offices = \Institute\Office::lists('nombre', 'id');
        return view('admin/teacher.edit',['teacher'=>$this->teacher,'offices'=>$offices,'biometrics'=>$biometrics,'subjects'=>$subjects]);
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
        $this->teacher->subjects()->detach();
        if (!empty($request['subjects'])){
            $this->teacher->subjects()->attach($request['subjects']);
        }
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
        $this->teacher->subjects()->detach();
        $this->teacher->delete();
        Session::flash('message','Docente borrado exitosamente');
        return Redirect::to('/admin/teacher');
    }
}
