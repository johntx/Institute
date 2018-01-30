<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Route;
use Institute\Startclass;
use Institute\Schedule;
use Institute\Hour;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->schedule = Schedule::find($route->getParameter('schedule'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::orderBy('id','DESC')->paginate(20);
        return view('admin/schedule.index',compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $semana = array("lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $horario = array('08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00');
        $startclasses = Startclass::
        join('careers','startclasses.career_id','=','careers.id')
        ->where('estado','!=','Cerrado')
        ->select('startclasses.*')
        ->orderBy('fecha_inicio','desc')->get();
        return view('admin/schedule.create',['startclasses'=>$startclasses,'semana'=>$semana,'horario'=>$horario]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $schedule = new Schedule();
        $schedule->fill([
            'descripcion' => $request['descripcion'],
            'activo' => $request['activo'],
            'fecha' => \Carbon\Carbon::now()
            ]);
        $col = collect();
        if (count($request['people_id'])>0) {
            for ($i=0; $i < count($request['people_id']); $i++) {
                $hour = new Hour;
                $hour->people_id = $request['people_id'][$i];
                $hour->aula = $request['aula'][$i];
                $hour->piso = $request['piso'][$i];
                $hour->hora_inicio = $request['hora_inicio'][$i];
                $hour->hora_fin = $request['hora_fin'][$i];
                $hour->dia = $request['dia'][$i];
                $hour->group_id = $request['group_id'][$i];
                $hour->career_id = $request['career_id'][$i];
                $hour->subject_id = $request['subject_id'][$i];
                $col->push($hour);
            }
        }
        $schedule->save();
        $schedule->hours()->saveMany($col);
        Session::flash('message','Horario registrado exitosamente');
        return Redirect::to('/admin/schedule');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/schedule.delete',['schedule'=>$this->schedule]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $semana = collect(["lunes", "martes", "miercoles", "jueves", "viernes", "sabado"]);
        $horario = collect(['08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00']);
        $startclasses = Startclass::
        join('careers','startclasses.career_id','=','careers.id')
        ->where('estado','!=','Cerrado')
        ->select('startclasses.*')
        ->orderBy('fecha_inicio','desc')->get();
        return view('admin/schedule.edit',['schedule'=>$this->schedule, 'startclasses'=>$startclasses,'semana'=>$semana,'horario'=>$horario]);
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
        $this->schedule->fill([
            'descripcion' => $request['descripcion'],
            'activo' => $request['activo'],
            'fecha' => \Carbon\Carbon::now()
            ]);
        $this->schedule->hours->each(function($hour)
        {
            $hour->delete();
        });
        $col = collect();
        if (count($request['people_id'])>0) {
            for ($i=0; $i < count($request['people_id']); $i++) {
                $hour = new Hour;
                $hour->people_id = $request['people_id'][$i];
                $hour->aula = $request['aula'][$i];
                $hour->piso = $request['piso'][$i];
                $hour->hora_inicio = $request['hora_inicio'][$i];
                $hour->hora_fin = $request['hora_fin'][$i];
                $hour->dia = $request['dia'][$i];
                $hour->group_id = $request['group_id'][$i];
                $hour->career_id = $request['career_id'][$i];
                $hour->subject_id = $request['subject_id'][$i];
                $col->push($hour);
            }
        }
        $this->schedule->save();
        $this->schedule->hours()->saveMany($col);
        Session::flash('message','Horario editado exitosamente');
        return Redirect::to('/admin/schedule');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->schedule->hours->each(function($hour)
        {
            $hour->delete();
        });
        $this->schedule->delete();
        Session::flash('message','Menu borrado exitosamente');
        return Redirect::to('/admin/schedule');
    }
}
