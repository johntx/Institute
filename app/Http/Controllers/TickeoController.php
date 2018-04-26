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
        return view('admin/tickeo.Myindex',['people_id'=>Auth::user()->id]);
    }

    public function tickeo($id)
    {
        return view('admin/tickeo.index',['people_id'=>$id]);
    }

    public function tickeoEmpleado($id, $fecha)
    {
        $people = \Institute\People::find($id);
        $hours = $this->horas_por_dia($people);
        //return $hours;
        $tickeos = Tickeo::where('biometric_id',$people->code)->whereBetween('fecha', array($fecha, Carbon::now()))->orderBy('fecha','asc')->get();
        if (count($tickeos)==0) {
            return "Rango de fechas: ".$fecha." a ".Carbon::now()->format('Y-m-d').": No hay tiqueos para mostrar";
        }
        //return $tickeos;
        $col = collect();
        $fechas = collect();
        $date = Carbon::parse($fecha);
        do {
            $fechas->push($date->format('Y-m-d'));
            $date->addDay();
        } while ($date->format('Y-m-d') <= Carbon::now()->format('Y-m-d'));
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
        //return $fechas;
        $view =  view('pdf/PDFTickeo', ['tickeos'=>$col,'hours'=>$hours, 'fechas'=>$fechas,'people'=>$people])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('Tickeos '.$tickeos->first()->biometric->nombre.'.pdf');
    }

    public function horas_por_dia($people)
    {
        $semana = collect(["lunes", "martes", "miercoles", "jueves", "viernes", "sabado"]);
        $TodasLasHoras = collect();
        foreach ($semana as $key => $dia) {
            $hours_dia = \Institute\Hour::join('schedules','hours.schedule_id','=','schedules.id')->select('hours.*')->where('people_id',$people->id)->where('vigente','si')->where('dia',$dia)->groupBy('hora_inicio')->orderBy('hora_inicio','asc')->get();
            $horas_fusion = collect();
            $horas_fusion->push($hours_dia->first());
            $hours_dia=$hours_dia->reverse();
            $hours_dia->pop();
            $hours_dia=$hours_dia->reverse();
            //return $hours_dia;
            foreach ($hours_dia as $hora) {
                if ($hora->hora_inicio == $horas_fusion->last()->hora_fin) {
                    $horas_fusion->last()->hora_fin = $hora->hora_fin;
                } else {
                    $horas_fusion->push($hora);
                }
            }
            $TodasLasHoras->push($horas_fusion);
            $collapsed = $TodasLasHoras->collapse();
        }
        return $collapsed;
    }
    public function fusion_horas($horas)
    {
        return $horas;
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
    public function logTickeoEmpleado($id, $fecha)
    {
        $people = \Institute\People::find($id);
        $hours = $this->horas_por_dia($people);
        //return $hours;
        $tickeos = Tickeo::where('biometric_id',$people->code)->whereBetween('fecha', array($fecha, Carbon::now()))->orderBy('fecha','asc')->get();
        if (count($tickeos)==0) {
            return "Rango de fechas: ".$fecha." a ".Carbon::now()->format('Y-m-d').": No hay tiqueos para mostrar";
        }
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
        //return $col;
        $view =  view('pdf/PDFLogTickeo', ['tickeos'=>$col,'hours'=>$hours])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('Tickeos '.$tickeos->first()->biometric->nombre.'.pdf');
    }
    public function MiLogTickeo($id, $fecha)
    {
        $people = \Institute\People::find($id);
        $hours = $this->horas_por_dia($people);
        $tickeos = Tickeo::where('biometric_id',$people->code)->whereBetween('fecha', array($fecha, Carbon::now()))->orderBy('fecha','desc')->get();
        if (count($tickeos)==0) {
            return "Rango de fechas: ".$fecha." a ".Carbon::now()->format('Y-m-d').": No hay tiqueos para mostrar";
        }
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
        return view('admin/tickeo.verMiTickeo',['tickeos'=>$col,'hours'=>$hours]);
    }
}
