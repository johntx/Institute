<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Collection;
use Illuminate\Routing\Route;
use Institute\Role;
use DB;
use Validator;
use Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->role = Role::find($route->getParameter('role'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate(15);
        return view('admin/role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = \Institute\Menu::all();
        return view('admin/role.create',['menus'=>$menus]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['code']=strtoupper($request['code']);
        $request['name']=strtoupper($request['name']);
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles',
            ]);

        if ($validator->fails()) {
            return redirect('/admin/role/create')
            ->withErrors($validator)
            ->withInput();
        }
        Role::create($request->all());
        if (!empty($request['functionalities'])){
            $role = Role::where('code', '=', $request['code'])->first();
            $role->functionalities()->attach($request['functionalities']);
        }
        Session::flash('message','Rol registrado exitosamente');
        return Redirect::to('/admin/role');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menus = \Institute\Menu::all();
        return view('admin/role.delete',['role'=>$this->role,'menus'=>$menus]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menus = \Institute\Menu::all();
        return view('admin/role.edit',['role'=>$this->role,'menus'=>$menus]);
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
        $request['code']=strtoupper($request['code']);
        $request['name']=ucwords(strtolower($request['name']));
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:roles,code,'.$id.',id',
            'name' => 'required|unique:roles,name,'.$id.',id'
            ]);

        if ($validator->fails()) {
            return redirect('/admin/role/'.$id.'/edit')
            ->withErrors($validator)
            ->withInput();
        }
        $c = collect();
        $this->role->fill($request->all());
        $this->role->save();
        $this->role->functionalities()->detach();
        if (!empty($request['functionalities'])){
            $this->role->functionalities()->attach($request['functionalities']);
        }
        Session::put('functionalities',Auth::user()->role->functionalities);
        Session::flash('message','Rol editado exitosamente');
        return Redirect::to('/admin/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->role->users->each(function($user)
        {
            $role = \RRHH\Role::where('code', 'DIS')->first();
            $user->role_id = $role->id;
        });
        $this->role->delete();
        Session::flash('message','Rol borrado exitosamente');
        return Redirect::to('/admin/role');
    }
}
