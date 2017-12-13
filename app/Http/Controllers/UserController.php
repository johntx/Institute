<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Institute\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Http\Requests\UserCreateRequest;
use Validator;
use Illuminate\Routing\Route;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->user = User::find($route->getParameter('user'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id','DESC')->paginate(15);
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \Institute\Role::lists('name', 'id');
        return view('user.create',['roles'=>$roles]);
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
            'user' => 'required|unique:users',
            ]);
        if ($validator->fails()) {
            return redirect('/admin/client/create')
            ->withErrors($validator)
            ->withInput();
        }
        User::create($request->all());
        Session::flash('message','Usuario registrado exitosamente');
        return Redirect::to('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $roles = \Institute\Role::lists('name', 'id');
        return view('user.delete',['user'=>$this->user, 'roles'=>$roles]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $roles = \Institute\Role::lists('name', 'id');
        return view('user.edit',['user'=>$this->user, 'roles'=>$roles]);
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
        $validator = Validator::make($request->all(), [
            'user' => 'required|unique:users,user,'.$id.',id'
            ]);
        if ($validator->fails()) {
            return redirect('/user/'.$id.'/edit')
            ->withErrors($validator)
            ->withInput();
        }
        $this->user->fill($request->all());
        $this->user->save();
        Session::flash('message','Usuario editado exitosamente');
        return Redirect::to('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->user->client !=null) {
            $this->user->client->delete();
        }
        if ($this->user->employee !=null) {
            $this->user->employee->delete();
        }
        $this->user->delete();
        Session::flash('message','Usuario borrado exitosamente');
        return Redirect::to('/user');
    }
}
