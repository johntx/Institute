<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Assistance;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class AssistanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show','horario']]);
    }
    public function find(Route $route)
    {
        $this->teacher = Assistance::find($route->getParameter('teacher'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $assistances = Assistance::join('users','peoples.id','=','users.id')
        ->join('roles','users.role_id','=','roles.id')
        ->select('peoples.*')
        ->where('roles.code','DOC')
        ->orderBy('users.id','DESC')
        ->paginate(20);
        return view('admin/assistance.index',compact('assistances'));
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
    public function show($id)
    {
        $inscriptions = \Institute\Inscription::where('group_id',$id)->get();
        return view('admin/assistance.index',['inscriptions'=>$inscriptions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }
    public function register($piso, $aula, $dia)
    {
        $hours = \Institute\Hour::join('schedules','hours.schedule_id','=','schedules.id')->where('schedules.vigente','si')->where('people_id',Auth::id())->where('piso',$piso)->where('aula',$aula)->where('dia',$dia)->get();
        return view('admin/assistance.index',['hours'=>$hours]);
    }
    public function ver($id)
    {
        $inscriptions = \Institute\Inscription::leftjoin('assistances','assistances.inscription_id','=','inscriptions.id')
        ->join('peoples','inscriptions.people_id','=','peoples.id')
        ->select('inscriptions.*','assistances.asistencia as asistencia')
        ->where('inscriptions.group_id',$id)
        ->groupBy('inscriptions.id')
        ->orderBy('peoples.nombre','asc')
        ->get();
        $asistencias = \Institute\Assistance::where('asistencia',1)
        ->where('group_id',$id)
        ->groupBy('fecha','subject_id')
        ->orderBy('fecha','asc')
        ->get();
        $group = \Institute\Group::find($id);
        return view('admin/assistance.ver',['inscriptions'=>$inscriptions,'group'=>$group,'asistencias'=>$asistencias]);
    }
    public function myassistance()
    {
        return view('admin/assistance.myassistance');
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
        if ($id == \Carbon\Carbon::now()->format('Y-m-d')) {
            $assistances = \Institute\Assistance::where('fecha',\Carbon\Carbon::now()->format('Y-m-d'))
            ->where('asistencia',1)
            ->where('group_id',$request['group_id'])
            ->where('subject_id',$request['materia_id'])
            ->where('people_id',Auth::user()->id)
            ->get();
            $assistances->each(function($assistance)
            {
                $assistance->delete();
            });
        }
        for ($i=0; $i < count($request['asistencia']); $i++) {
            $assistance = new Assistance();
            $assistance->fill([
                'fecha' => $id,
                'asistencia' => 1,
                'inscription_id' => $request['asistencia'][$i],
                'people_id' => Auth::user()->id,
                'group_id' => $request['group_id'],
                'subject_id' => $request['materia_id']
                ]);
            $assistance->save();
        }
        return Redirect::to('admin/group/my/group');
    }

    public function assistance_ajax_00(Request $request)
    {
        if ($request->ajax()) {
            if ($request['asistencia']==$request['inscription_id']) {
                $Dassistance = \Institute\Assistance::where('fecha',\Carbon\Carbon::now()->format('Y-m-d'))
                ->where('asistencia',1)
                ->where('group_id',$request['group_id'])
                ->where('subject_id',$request['materia_id'])
                ->where('inscription_id',$request['inscription_id'])
                ->where('people_id',Auth::user()->id)
                ->first();
                if (count($Dassistance)>0) {
                    $Dassistance->delete();
                } else {
                    $assistance = new Assistance();
                    $assistance->fill([
                        'fecha' => \Carbon\Carbon::now(),
                        'asistencia' => 1,
                        'inscription_id' => $request['inscription_id'],
                        'people_id' => Auth::user()->id,
                        'group_id' => $request['group_id'],
                        'subject_id' => $request['materia_id']
                        ]);
                    $assistance->save();
                }
            } else {
                $Dassistance = \Institute\Assistance::where('fecha',\Carbon\Carbon::now()->format('Y-m-d'))
                ->where('asistencia',1)
                ->where('group_id',$request['group_id'])
                ->where('subject_id',$request['materia_id'])
                ->where('inscription_id',$request['inscription_id'])
                ->where('people_id',Auth::user()->id)
                ->first();
                $Dassistance->delete();
            }
        }
        $response_array['status'] = 'success';    
        return json_encode($response_array);
    }

    public function assistance_ajax(Request $request)
    {
        if ($request->ajax()) {
            $asistencia = 1;
            if ($request['sacaba'][0]!=null) {
                $request['asistencia'] = $request['sacaba'][0];
                $asistencia = 2;
            }
            if ($request['socabon'][0]!=null) {
                $request['asistencia'] = $request['socabon'][0];
                $asistencia = 3;
            }
            if ($request['asistencia']==$request['inscription_id']) {
                $Dassistance = \Institute\Assistance::where('fecha',\Carbon\Carbon::now()->format('Y-m-d'))
                ->where('asistencia',$asistencia)
                ->where('group_id',$request['group_id'])
                ->where('subject_id',$request['materia_id'])
                ->where('inscription_id',$request['inscription_id'])
                ->where('people_id',Auth::user()->id)
                ->first();
                if (count($Dassistance)>0) {
                    $Dassistance->delete();
                } else {
                    $assistance = new Assistance();
                    $assistance->fill([
                        'fecha' => \Carbon\Carbon::now(),
                        'asistencia' => $asistencia,
                        'inscription_id' => $request['inscription_id'],
                        'people_id' => Auth::user()->id,
                        'group_id' => $request['group_id'],
                        'subject_id' => $request['materia_id']
                        ]);
                    $assistance->save();
                }
            } else {
                $Dassistance = \Institute\Assistance::where('fecha',\Carbon\Carbon::now()->format('Y-m-d'))
                ->where('group_id',$request['group_id'])
                ->where('subject_id',$request['materia_id'])
                ->where('inscription_id',$request['inscription_id'])
                ->where('people_id',Auth::user()->id)
                ->first();
                $Dassistance->delete();
            }
        }
        $response_array['status'] = 'success';    
        return json_encode($response_array);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
