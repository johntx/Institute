<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Tickeo;
use Illuminate\Routing\Route;
use Validator;
use Auth;
use Carbon\Carbon;
use Jenssegers\Date\Date;

class TickeoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->tickeo = Tickeo::find($route->getParameter('tickeo'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickeos = Tickeo::where('biometric_id',Auth::user()->people->code)->orderBy('fecha','DESC')->paginate(30);
        return view('admin/tickeo.index');
        return view('admin/tickeo.index',compact('tickeos'));
    }

    public function tickeo($id)
    {
        $tickeos = Tickeo::where('biometric_id',Auth::user()->people->code)->orderBy('fecha','DESC')->paginate(30);
        return view('admin/teacher.tickeo',['biometric_id'=>$id]);
    }
    public function tickeoEmpleado($id, $fecha)
    {
        $tickeos = Tickeo::where('biometric_id',$id)->whereBetween('fecha', array($fecha, Carbon::now()))->orderBy('fecha','asc')->get();
        $col = collect();
        $tickeos->first()->dia = Date::parse($tickeos->first()->fecha)->format('l');
        $col->push($tickeos->first());
        foreach ($tickeos as $key => $tickeo) {
            $fecha_tickeo = Date::parse($tickeo->fecha);
            $fecha_col = Date::parse($col->last()->fecha);
            if ($fecha_tickeo->diffInMinutes($fecha_col) <= 1 && $tickeo->tipo == $col->last()->tipo) {
            } else {
                $tickeo->dia = $fecha_tickeo->format('l');
                $col->push($tickeo);
            }
        }
        $view =  view('pdf/PDFTickeo', ['tickeos'=>$col])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('Tickeos '.$tickeos->first()->biometric->nombre.'.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        return 'hola';
        return view('admin/tickeo.delete',['tickeo'=>$this->tickeo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin/tickeo.edit',['tickeo'=>$this->tickeo]);
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
        $this->tickeo->fill([
            'fecha' => \Carbon\Carbon::now(),
            'glosa' => $request['glosa'],
            'monto' => $request['monto'],
            'codigo' => $request['codigo'],
            'tipo' => $request['tipo'],
            'user_id' => Auth::user()->id
            ]);
        $this->tickeo->save();
        Session::flash('message','Egreso editado exitosamente');
        return Redirect::to('/admin/tickeo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        return 'hola';
    }
}
