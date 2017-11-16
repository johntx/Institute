<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Functionality;
use Illuminate\Routing\Route;
use Validator;

class FunctionalityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->functionality = Functionality::find($route->getParameter('functionality'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $functionalities = Functionality::orderBy('id', 'desc')->paginate(15);
        return view('admin/functionality.index',compact('functionalities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = \Institute\Menu::orderBy('id','DESC')->lists('label', 'id');
        return view('admin/functionality.create',['menus'=>$menus]);
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
        $request['label']=ucwords(strtolower($request['label']));
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:functionalities',
            'path' => 'required|unique:functionalities',
            'label' => 'required|unique:functionalities',
            ]);

        if ($validator->fails()) {
            return redirect('/admin/functionality/create')
            ->withErrors($validator)
            ->withInput();
        }
        Functionality::create($request->all());
        Session::flash('message','Funcionalidad registrada exitosamente');
        return Redirect::to('/admin/functionality');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menus = \Institute\Menu::lists('label', 'id');
        return view('admin/functionality.delete',['functionality'=>$this->functionality,'menus'=>$menus]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menus = \Institute\Menu::lists('label', 'id');
        return view('admin/functionality.edit',['functionality'=>$this->functionality,'menus'=>$menus]);
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
        $request['label']=ucwords(strtolower($request['label']));
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:functionalities,code,'.$id.',id',
            'path' => 'required|unique:functionalities,path,'.$id.',id',
            'label' => 'required|unique:functionalities,label,'.$id.',id'
            ]);

        if ($validator->fails()) {
            return redirect('/admin/functionality/'.$id.'/edit')
            ->withErrors($validator)
            ->withInput();
        }
        $this->functionality->fill($request->all());
        $this->functionality->save();
        Session::flash('message','Funcionalidad editada exitosamente');
        return Redirect::to('/admin/functionality');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->functionality->roles->each(function ($role)
        {
            $role->users->each(function($user)
            {
                $role = \RRHH\Role::where('code', 'DIS')->first();
                $user->role_id = $role->id;
            });
            $role->delete();
        });
        $this->functionality->delete();
        Session::flash('message','Funcionalidad eliminada exitosamente');
        return Redirect::to('/admin/functionality');
    }
}
