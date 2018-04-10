<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Evaluation;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class EvaluationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->evaluation = Evaluation::find($route->getParameter('evaluation'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluations = Evaluation::orderBy('id','DESC')->paginate(20);
        return view('admin/evaluation.index',compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $fecha_actual = \Carbon\Carbon::now()->format('Y-m-d');
        $fecha_fin = \Carbon\Carbon::now();
        $fecha_fin->day(1);
        $fecha_fin->addMonth();
        $fecha_fin->subDay();

        $fecha_inicio = \Carbon\Carbon::now();
        $fecha_inicio->day(1);
        $fecha_inicio->addMonth();
        $fecha_inicio->subDay(7);
        $fecha_inicio->format('Y-m-d');
        if ($fecha_inicio<=$fecha_actual) {
            $b = false;
            foreach ($user->people->inscriptions as $inscription) {
                foreach (\Institute\People::select('peoples.*')->join('users','peoples.id','=','users.id')->join('roles','users.role_id','=','roles.id')->join('hours','peoples.id','=','hours.people_id')->join('schedules','hours.schedule_id','=','schedules.id')->join('groups','hours.group_id','=','groups.id')->where('roles.code','DOC')->where('schedules.vigente','si')->where('groups.id',$inscription->group->id)->distinct()->get() as $teacher) {
                    $evaluations = \Institute\Evaluation::whereBetween('fecha', array( $fecha_inicio, $fecha_fin))->where('inscription_id',$inscription->id)->where('people_id',$teacher->id)->get();
                    if (count($evaluations)==0) {
                        /*esta vacio debe llenar para este docente*/
                        return view('admin/evaluation.create',['inscription'=>$inscription,'fecha_actual'=>$fecha_actual,'fecha_inicio'=>$fecha_inicio,'teacher'=>$teacher]);
                    }
                }
            }
            Session::flash('message','Todas las evaluaciones ya fueron realizadas');
        } else {
            Session::flash('message','Las Evaluaciones aún no estan disponibles');
        }
        return Redirect::to('/admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $evaluation = new Evaluation;
        $evaluation->fecha = \Carbon\Carbon::now();
        $evaluation->people_id = $request['people_id'];
        $evaluation->inscription_id = $request['inscription_id'];
        $evaluation->p1 = $request['p1'];
        $evaluation->p2 = $request['p2'];
        $evaluation->p3 = $request['p3'];
        $evaluation->p4 = $request['p4'];
        $evaluation->p5 = $request['p5'];
        $evaluation->p6 = $request['p6'];
        $evaluation->save();
        Session::flash('message','Evaluación registrada exitosamente');
        return Redirect::to('admin/evaluation/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/evaluation.delete',['evaluation'=>$this->evaluation]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjects = \Institute\Subject::orderBy('nombre','asc')->get();
        return view('admin/evaluation.edit',['evaluation'=>$this->evaluation,'subjects'=>$subjects]);
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
        $this->evaluation->fill($request->all());
        $this->evaluation->save();
        $this->evaluation->subjects()->detach();
        if (!empty($request['subjects'])){
            $this->evaluation->subjects()->attach($request['subjects']);
        }
        Session::flash('message','Evaluación editada exitosamente');
        return Redirect::to('/admin/evaluation');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->evaluation->delete();
        Session::flash('message','Evaluación borrada exitosamente');
        return Redirect::to('/admin/evaluation');
    }
}
