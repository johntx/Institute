<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Item;
use Illuminate\Routing\Route;
use Validator;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->item = Item::find($route->getParameter('item'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::orderBy('id','DESC')->get();
        return view('admin/item.index',['items'=>$items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = \Institute\Category::lists('nombre','id');
        $career = \Institute\Career::lists('nombre','id');
        return view('admin/item.create',['career'=>$career, 'categories'=>$categories, 'item'=>null]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Item::create($request->all());
        if (!empty($request['subjects'])){
            $item->subjects()->attach($request['subjects']);
        }
        Session::flash('message','Item registrada exitosamente');
        return Redirect::to('/admin/item');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/item.delete',['item'=>$this->item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = \Institute\Category::lists('nombre','id');
        $career = \Institute\Career::lists('nombre','id');
        return view('admin/item.edit',['item'=>$this->item,'categories'=>$categories,'career'=>$career]);
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
        $this->item->fill($request->all());
        $this->item->save();
        Session::flash('message','Item editada exitosamente');
        return Redirect::to('/admin/item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->item->delete();
        Session::flash('message','Item borrada exitosamente');
        return Redirect::to('/admin/item');
    }
}
