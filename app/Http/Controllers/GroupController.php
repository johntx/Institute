<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Group;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show','horario']]);
    }
    public function find(Route $route)
    {
        $this->group = Group::find($route->getParameter('group'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::join('startclasses','groups.startclass_id','=','startclasses.id')
        ->join('careers','careers.id','=','startclasses.career_id')
        ->select('groups.*')
        ->where('startclasses.estado','!=','Cerrado')
        ->orderBy('startclasses.fecha_inicio','DESC')->get();
        return view('admin/group.index',['groups'=>$groups]);
    }
    public function myGroup()
    {
        $groups = \Institute\Hour::join('schedules','hours.schedule_id','=','schedules.id')
        ->join('subjects','hours.subject_id','=','subjects.id')
        ->join('groups','hours.group_id','=','groups.id')
        ->join('startclasses','groups.startclass_id','=','startclasses.id')
        ->join('careers','startclasses.career_id','=','careers.id')
        ->select('groups.*','careers.nombre as carrera','startclasses.fecha_inicio as fecha_inicio','subjects.nombre as materia','subjects.id as materia_id')
        ->where('people_id',Auth::user()->id)
        ->where('schedules.vigente','si')
        ->distinct()
        ->get();
        return view('admin/group.myGroup',['groups'=>$groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $careers = \Institute\Career::lists('nombre', 'id');
        $startclasses = \Institute\Startclass::select('startclasses.*')
        ->where('startclasses.estado','!=','Cerrado')
        ->orderBy('fecha_inicio','DESC')
        ->get();
        return view('admin/group.create',['careers'=>$careers, 'startclasses'=>$startclasses]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fecha_actual = \Carbon\Carbon::now()->format('Y-m-d');
        $startclass = \Institute\Startclass::find($request['startclass_id']);

        if ($fecha_actual<=$startclass->fecha_fin) {
            $request['estado'] = 'Vigente';
        } else {
            $request['estado'] = 'Culminado';
        }
        Group::create($request->all());
        Session::flash('message','Grupo registrado exitosamente');
        return Redirect::to('/admin/group');
    }

    public function pdf($id)
    {
        $semana = array("hora","lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $horario = array('07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00');
        $group = Group::find($id);
        $view =  view('pdf/PDFHorarioGrupo', ['group'=>$group,'semana'=>$semana,'horario'=>$horario])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a5', 'landscape');
        return $pdf->stream('Horario '.$group->turno.'.pdf');
    }

    public function pdfanticipado($id)
    {
        $semana = array("hora","lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $horario = array('07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00');
        $group = Group::find($id);
        $view =  view('pdf/PDFHorarioGrupoAnticipado', ['group'=>$group,'semana'=>$semana,'horario'=>$horario])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a5', 'landscape');
        return $pdf->stream('Horario '.$group->turno.'.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/group.delete',['group'=>$this->group]);
    }

    public function horario($id)
    {
        $semana = array("hora","lunes", "martes", "miercoles", "jueves", "viernes", "sabado");
        $horario = array('07:30','08:00','08:30','09:00','09:30','10:00','10:30','11:00','11:30','12:00','12:30','13:00','13:30','14:00','14:30','15:00','15:30','16:00','16:30','17:00','17:30','18:00','18:30','19:00','19:30','20:00');
        return view('admin/group.horario',['group'=>$this->group,'semana'=>$semana,'horario'=>$horario]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $startclasses = \Institute\Startclass::select('startclasses.*')
        ->orderBy('fecha_inicio','DESC')
        ->get();
        $careers = \Institute\Career::lists('nombre', 'id');
        return view('admin/group.edit',['group'=>$this->group, 'careers'=>$careers, 'startclasses'=>$startclasses]);
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
        $fecha_actual = \Carbon\Carbon::now()->format('Y-m-d');
        $startclass = \Institute\Startclass::find($request['startclass_id']);

        if ($fecha_actual<=$startclass->fecha_fin) {
            $request['estado'] = 'Vigente';
        } else {
            $request['estado'] = 'Culminado';
        }
        $this->group->fill($request->all());
        $this->group->save();
        Session::flash('message','Grupo editado exitosamente');
        return Redirect::to('/admin/group');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hours = \Institute\Hour::where('group_id',$this->group->id)->get();
        foreach ($hours as $hour) {
            $hour->delete();
        }
        $this->group->delete();
        Session::flash('message','Grupo borrado exitosamente');
        return Redirect::to('/admin/group');
    }
}
