<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Menu;
use Illuminate\Routing\Route;
use Validator;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->menu = Menu::find($route->getParameter('menu'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::orderBy('id','DESC')->paginate(20);
        return view('admin/menu.index',compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/menu.create');
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
            'code' => 'required|unique:menus',
            'label' => 'required|unique:menus',
            ]);

        if ($validator->fails()) {
            return redirect('/admin/menu/create')
            ->withErrors($validator)
            ->withInput();
        }
        Menu::create($request->all());
        Session::flash('message','Menu registrado exitosamente');
        return Redirect::to('/admin/menu');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/menu.delete',['menu'=>$this->menu]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin/menu.edit',['menu'=>$this->menu]);
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
            'code' => 'required|unique:menus,code,'.$id.',id',
            'label' => 'required|unique:menus,label,'.$id.',id'
            ]);

        if ($validator->fails()) {
            return redirect('/admin/menu/'.$id.'/edit')
            ->withErrors($validator)
            ->withInput();
        }
        $this->menu->fill($request->all());
        $this->menu->save();
        Session::flash('message','Menu editado exitosamente');
        return Redirect::to('/admin/menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->menu->functionalities->each(function($functionality){
            $functionality->roles->each(function ($role)
            {
                $role->users->each(function($user)
                {
                    $role = \Institute\Role::where('code', 'DIS')->first();
                    $user->role_id = $role->id;
                });
                $role->delete();
            });
            $functionality->delete();
        });
        $this->menu->delete();
        Session::flash('message','Menu borrado exitosamente');
        return Redirect::to('/admin/menu');
    }
}
