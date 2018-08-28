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
        $this->middleware('admin',['only' => ['index','create','edit']]);
        $this->beforeFilter('@find',['only' => ['edit','update','show','observar']]);
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

    public function observar($id)
    {
        $tickeo = Tickeo::find($id);
        $tickeo->estado = "observado";
        $tickeo->save();
        return $tickeo->estado;
        return view('admin/tickeo.index',['people_id'=>$id]);
    }

    public function tickeoEmpleado($id, $fecha)
    {
        $people = \Institute\People::find($id);
        $fechas = collect();
        $date = Carbon::parse($fecha);
        do {
            $fechas->push($date->format('Y-m-d'));
            $date->addDay();
        } while ($date->format('Y-m-d') <= Carbon::now()->format('Y-m-d'));
        return view('admin/tickeo.verMiTickeo',['fechas'=>$fechas,'people'=>$people]);
    }

    public function payment_ajax(Request $request)
    {
        if ($request->ajax()) {
            if (0<count($request['fecha'])){
                for ($i=0; $i < count($request['fecha']); $i++) {
                    $tickeos = Tickeo::select('tickeos.*')->where('biometric_id',$request['code'])->whereBetween('fecha',array(Carbon::parse($request['fecha'][$i])->format('Y-m-d 00:00:00'),Carbon::parse($request['fecha'][$i])->format('Y-m-d 23:59:59')))->where('estado','!=','invalido')->get();
                    $tickeos->each(function($tickeo){
                        $tickeo->cancelado = "si";
                        $tickeo->save();
                    });
                }
                $people = \Institute\People::find($request['people_id']);
                $egress = new \Institute\Egress;
                $h = explode(":", $request["horas"]);
                $egress->fill([
                    'fecha' => \Carbon\Carbon::now(),
                    'glosa' => "Pago de salario a empleado ".$people->nombrecompleto().". Con cantidad de horas sumadas: ".$h[0]." hrs. y ".$h[1]." min.",
                    'monto' => $request['monto'],
                    'tipo' => "Pago de Horas",
                    'people_id' => $request['people_id'],
                    'user_id' => Auth::user()->id
                    ]);
                $egress->save();
            } else {
                header('HTTP/1.1 500 No hay tickeos');
                header('Content-Type: application/json; charset=UTF-8');
                die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
            }
            Session::flash('success','Proceso concluido');
            return $request['people_id'];
        }
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
        $validator = Validator::make($request->all(), [
            'fecha' => 'required|unique:tickeos',
            ]);

        if ($validator->fails()) {
            return Redirect::to(str_replace("/cien/public/", "", $request['url']));
        }
        $tickeo = Tickeo::create($request->all());
        if (!empty($request['subjects'])){
            $tickeo->subjects()->attach($request['subjects']);
        }
        Session::flash('alert','Tickeo en fecha y hora repetidos');
        return Redirect::to(str_replace("/cien/public/", "", $request['url']));
        Session::flash('success','Tickeo registrada exitosamente');
        return Redirect::to('/admin/item');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        return view('admin');
        return 'hola';
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
        if ($this->tickeo->estado == 'creado') {
            $this->tickeo->delete();
        }
        if ($this->tickeo->estado == "invalido") {
            $this->tickeo->estado = "";
            $this->tickeo->save();
        } elseif ($this->tickeo->estado == '' || $this->tickeo->estado == 'observado') {
            $this->tickeo->estado = 'invalido';
            $this->tickeo->save();
        }
        return Redirect::to(str_replace("/cien/public/", "", $request['url']));
        Session::flash('success','Egreso editado exitosamente');
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
        return 'entra';
        $this->tickeo->estado = 'invalido';
        $this->tickeo->save();
        $link = str_replace("/cien/public/", "", str_replace("/admin", "admin", $request['url']));
        return $link;
        return Redirect::to($link);
        return false;
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
        return view('admin/tickeo.verMiLogTickeo',['tickeos'=>$col,'hours'=>$hours]);
    }
}
