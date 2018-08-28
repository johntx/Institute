<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Extra;
use Illuminate\Routing\Route;
use Validator;

class ExtraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->extra = Extra::find($route->getParameter('extra'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $extras = Extra::orderBy('id','DESC')->paginate(20);
        return view('admin/extra.index',compact('extras'));
    }

    public function curso($id)
    {
        $inscriptions = \Institute\Inscription::select('inscriptions.*')
        ->join('inscriptions_extras','inscriptions.id','=','inscriptions_extras.inscription_id')
        ->join('extras','inscriptions_extras.extra_id','=','extras.id')
        ->join('payments','inscriptions.id','=','payments.inscription_id')
        ->where('inscriptions.estado','Inscrito')
        ->where('extras.id',$id)
        ->distinct('inscriptions.id')
        ->orderBy('inscriptions.fecha_ingreso','DESC')
        ->get();
        $curso = Extra::find($id);
        return view('admin/extra.curso',['inscriptions'=>$inscriptions,'curso'=>$curso]);
    }
    public function filtro(Request $request)
    {
        $socabon = collect();
        for ($i=0; $i < count($request['socabon']); $i++) {
            $ins = \Institute\Inscription::find($request['socabon'][$i]);
            $socabon->push($ins);
        }
        $oasis = collect();
        for ($i=0; $i < count($request['oasis']); $i++) {
            $ins = \Institute\Inscription::find($request['oasis'][$i]);
            $oasis->push($ins);
        }
        $sacaba = collect();
        for ($i=0; $i < count($request['sacaba']); $i++) {
            $ins = \Institute\Inscription::find($request['sacaba'][$i]);
            $sacaba->push($ins);
        }
        return view('admin/extra.filtro',['socabon'=>$socabon,'oasis'=>$oasis,'sacaba'=>$sacaba]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/extra.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $extra = Extra::create($request->all());
        Session::flash('success','Curso extra registrado exitosamente');
        return Redirect::to('/admin/extra');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/extra.delete',['extra'=>$this->extra]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin/extra.edit',['extra'=>$this->extra]);
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
        $this->extra->fill($request->all());
        $this->extra->save();
        Session::flash('success','Curso extra editado exitosamente');
        return Redirect::to('/admin/extra');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->extra->delete();
        Session::flash('success','Curso extra borrado exitosamente');
        return Redirect::to('/admin/extra');
    }
}
