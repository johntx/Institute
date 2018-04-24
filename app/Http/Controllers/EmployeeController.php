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

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->employee = People::find($route->getParameter('employee'));
        $this->user = User::find($route->getParameter('employee'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = People::join('users','peoples.id','=','users.id')
        ->join('roles','users.role_id','=','roles.id')
        ->select('peoples.*')
        ->where('roles.code','!=','EST')
        ->where('roles.code','!=','DOC')
        ->where('roles.code','!=','ROOT')
        ->orderBy('users.id','DESC')
        ->paginate(20);
        return view('admin/employee.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $biometrics = \Institute\Biometric::get();
        $roles = \Institute\Role::where('roles.code','!=','ROOT')
        ->where('roles.code','!=','ADM')
        ->where('roles.code','!=','EST')
        ->where('roles.code','!=','DOC')
        ->lists('name', 'id');
        $offices = \Institute\Office::lists('nombre', 'id');
        return view('admin/employee.create',['biometrics'=>$biometrics, 'roles'=>$roles, 'offices'=>$offices]);
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
        $request['paterno']=strtoupper($request['paterno']);
        $validator = Validator::make($request->all(), [
            'user' => 'required|unique:users',
            ]);
        if ($validator->fails()) {
            return redirect('/admin/employee/create')
            ->withErrors($validator)
            ->withInput();
        }
        $user = new User;
        $user->fill([
            'user' => $request['user'],
            'password' => $request['password'],
            'role_id' => $request['role_id']
            ]);
        $people = new People;
        $people->fill([
            'id' => $user->id,
            'ci' => $request['ci'],
            'nombre' => $request['nombre'],
            'paterno' => $request['paterno'],
            'fecha_ingreso' => \Carbon\Carbon::now(),
            'fecha_nacimiento' => $request['fecha_nacimiento'],
            'direccion' => $request['direccion'],
            'telefono' => $request['telefono'],
            'office_id' => $request['office_id']
            ]);
        //return $user;
        $user->save();
        $user->people()->save($people);
        Session::flash('message','Empleado registrado exitosamente');
        return Redirect::to('/admin/employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/employee.delete',['employee'=>$this->employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $biometrics = \Institute\Biometric::get();
        $roles = \Institute\Role::where('roles.code','!=','ROOT')
        ->where('roles.code','!=','EST')
        ->where('roles.code','!=','DOC')
        ->lists('name', 'id');
        $offices = \Institute\Office::lists('nombre', 'id');
        return view('admin/employee.edit',['biometrics'=>$biometrics, 'employee'=>$this->employee, 'roles'=>$roles, 'offices'=>$offices]);
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
        $request['paterno']=strtoupper($request['paterno']);
        $validator = Validator::make($request->all(), [
            'user' => 'required|unique:users,user,'.$id.',id'
        ]);
        if ($validator->fails()) {
            return redirect('/admin/employee/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }
        $this->user->fill($request->all());
        $this->employee->fill($request->all());
        $this->user->save();
        $this->employee->save();
        Session::flash('message','Empleado editado exitosamente');
        return Redirect::to('/admin/employee');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->employee->delete();
        Session::flash('message','Empleado borrado exitosamente');
        return Redirect::to('/admin/employee');
    }
}
