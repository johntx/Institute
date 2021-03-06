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
use Auth;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show','ver','clonar']]);
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
        $classrooms = \Institute\Classroom::orderBy('area','desc')->orderBy('aula','asc')->get();
        $semana = array("lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $horario = array('07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00');
        $startclasses = Startclass::
        join('careers','startclasses.career_id','=','careers.id')
        ->where('estado','!=','Cerrado')
        ->select('startclasses.*')
        ->orderBy('careers.id','asc')
        ->orderBy('fecha_inicio','asc')->get();
        return view('admin/schedule.create',['startclasses'=>$startclasses,'classrooms'=>$classrooms,'semana'=>$semana,'horario'=>$horario]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['vigente']=='si') {
            $schedules = Schedule::where('vigente','si')->get();
            $schedules->each(function($sche)
            {
                $sche->vigente = 'no';
                $sche->save();
            });
        }
        $schedule = new Schedule();
        $schedule->fill([
            'descripcion' => $request['descripcion'],
            'vigente' => $request['vigente'],
            'fecha' => \Carbon\Carbon::now()
            ]);
        $col = collect();
        if (count($request['datos'])>0) {
            for ($i=0; $i < count($request['datos']); $i++) {
                $datos = explode("-", $request['datos'][$i]);
                if ($datos[0]!=null) {
                    $hour = new Hour;
                    $hour->people_id = $datos[0];
                    $hour->aula = $datos[1];
                    $hour->piso = $datos[2];
                    $hour->hora_inicio = $datos[3];
                    $hour->hora_fin = $datos[4];
                    $hour->dia = $datos[5];
                    $hour->group_id = $datos[6];
                    $hour->subject_id = $datos[7];
                    $hour->h = $datos[8];
                    $hour->periodos = $datos[9];
                    $col->push($hour);
                }
            }
        }
        $schedule->save();
        $schedule->hours()->saveMany($col);
        Session::flash('success','Horario registrado exitosamente');
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
        $classrooms = \Institute\Classroom::orderBy('area','desc')->orderBy('aula','asc')->get();
        $semana = array("lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $horas_semana = collect();
        foreach ($semana as $dia) {
            $horas_semana->put($dia,\Institute\Hour::join('schedules','hours.schedule_id','=','schedules.id')->select('hours.*')->where('schedules.id',$id)->where('hours.dia',$dia)->get());
        }
        $horario = collect(['07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00']);
        $startclasses = Startclass::
        join('careers','startclasses.career_id','=','careers.id')
        ->where('estado','!=','Cerrado')
        ->select('startclasses.*')
        ->orderBy('careers.id','asc')
        ->orderBy('fecha_inicio','asc')->get();
        $availables = \Institute\Available::get();
        return view('admin/schedule.edit',['schedule'=>$this->schedule, 'startclasses'=>$startclasses,'classrooms'=>$classrooms,'semana'=>$semana,'horario'=>$horario,'availables'=>$availables,'horas_semana'=>$horas_semana]);
    }

    public function ver($id)
    {
        $semana = array("lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $classrooms = \Institute\Classroom::orderBy('area','desc')->orderBy('aula','asc')->get();
        $horas_semana = collect();
        foreach ($semana as $dia) {
            $horas_semana->put($dia,\Institute\Hour::join('schedules','hours.schedule_id','=','schedules.id')->select('hours.*')->where('schedules.id',$id)->where('hours.dia',$dia)->get());
        }
        $horario = collect(['07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00']);
        return view('admin/schedule.show',['schedule'=>$this->schedule,'semana'=>$semana,'classrooms'=>$classrooms,'horario'=>$horario,'horas_semana'=>$horas_semana]);
    }

    public function clonar($id)
    {
        $horario = new Schedule();
        $horario->vigente='no';
        $horario->descripcion=$this->schedule->descripcion.' (clon)';
        $horario->fecha=\Carbon\Carbon::now();
        $horario->save();
        $col = collect();
        if (sizeof($this->schedule->hours)>0) {
            foreach ($this->schedule->hours as $hour2) {
                $hour = new Hour;
                $hour->people_id = $hour2->people_id;
                $hour->aula = $hour2->aula;
                $hour->piso = $hour2->piso;
                $hour->h = $hour2->h;
                $hour->hora_inicio = $hour2->hora_inicio;
                $hour->hora_fin = $hour2->hora_fin;
                $hour->periodos = $hour2->periodos;
                $hour->dia = $hour2->dia;
                $hour->group_id = $hour2->group_id;
                $hour->subject_id = $hour2->subject_id;
                $hour->h = $hour2->h;
                $col->push($hour);
            }
        }
        $horario->hours()->saveMany($col);
        Session::flash('success','Horario clonado exitosamente');
        return Redirect::to('/admin/schedule');
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
        if ($request['vigente']=='si') {
            $schedules = Schedule::where('vigente','si')->where('id','!=',$this->schedule->id)->get();
            $schedules->each(function($sche)
            {
                $sche->vigente = 'no';
                $sche->save();
            });
        }
        if ($request['vigente']=='anticipado') {
            $schedules = Schedule::where('vigente','anticipado')->where('id','!=',$this->schedule->id)->get();
            $schedules->each(function($sche)
            {
                $sche->vigente = 'no';
                $sche->save();
            });
        }
        $this->schedule->fill([
            'descripcion' => $request['descripcion'],
            'vigente' => $request['vigente'],
            'fecha' => \Carbon\Carbon::now()
            ]);
        $col = collect();
        if (count($request['datos'])>0) {
            for ($i=0; $i < count($request['datos']); $i++) {
                $datos = explode("-", $request['datos'][$i]);
                if ($datos[0]!=null) {
                    $hour = new Hour;
                    $hour->people_id = $datos[0];
                    $hour->aula = $datos[1];
                    $hour->piso = $datos[2];
                    $hour->hora_inicio = $datos[3];
                    $hour->hora_fin = $datos[4];
                    $hour->dia = $datos[5];
                    $hour->group_id = $datos[6];
                    $hour->subject_id = $datos[7];
                    $hour->h = $datos[8];
                    $hour->periodos = $datos[9];
                    $col->push($hour);
                }
            }
        }
        $this->schedule->save();
        $this->schedule->hours->each(function($hour)
        {
            $hour->delete();
        });
        $this->schedule->hours()->saveMany($col);
        Session::flash('success','Horario editado exitosamente');
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
        Session::flash('success','Menu borrado exitosamente');
        return Redirect::to('/admin/schedule');
    }

    public function myschedule()
    {
        $user = Auth::user();
        $inscriptions = $user->people->inscriptions;
        $semana = array("hora","lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $horario = array('07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00');
        return view('admin/schedule.myschedule',['inscriptions'=>$inscriptions,'semana'=>$semana,'horario'=>$horario]);
    }

    public function teacherMe()
    {
        $user = Auth::user();
        $semana = array("hora","lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $horario = array('07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00');
        return view('admin/schedule.teacherMe',['user'=>$user,'semana'=>$semana,'horario'=>$horario]);
    }
}
