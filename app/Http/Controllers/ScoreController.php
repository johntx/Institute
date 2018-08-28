<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Score;
use Institute\Test;
use Institute\Partial;
use Illuminate\Routing\Route;
use Auth;

class ScoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->score = Score::find($route->getParameter('score'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        if ($request['test_id']==null && $request['partial_id']!=null) {
            return Redirect::to('score/register/'.$request['group_id'].'/'.$request['subject_id']);
        }
        if ($request['score_id']!=null) {
            $score = Score::find($request['score_id']);
            $score->nota = $request['nota'];
            $score->save();
        } else {
            $score = new Score();
            $score->fill([
                'nota' => $request['nota'],
                'inscription_id' => $request['inscription_id'],
                'test_id' => $request['test_id'],
                'people_id' => Auth::id(),
                'group_id' => $request['group_id']
                ]);
            $score->save();
        }
        Session::flash('success','Ingreso de Item registrada exitosamente');

        return Redirect::to('score/register/'.$request['piso'].'/'.$request['aula'].'/'.$request['dia']);
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
        return view('admin/score.index',['inscriptions'=>$inscriptions]);
    }

    public function register($piso, $aula, $dia)
    {
        $hours = \Institute\Hour::join('schedules','hours.schedule_id','=','schedules.id')->where('schedules.vigente','si')->where('people_id',Auth::id())->where('piso',$piso)->where('aula',$aula)->where('dia',$dia)->get();
        return view('admin/score.index',['hours'=>$hours,'piso'=>$piso,'aula'=>$aula,'dia'=>$dia]);
    }
    public function ver($id)
    {
        $inscriptions = \Institute\Inscription::leftjoin('scores','scores.inscription_id','=','inscriptions.id')->join('peoples','inscriptions.people_id','=','peoples.id')->select('inscriptions.*','scores.nota as nota')->where('inscriptions.group_id',$id)->groupBy('inscriptions.id')->orderBy('peoples.nombre','asc')->get();
        $group = \Institute\Group::find($id);
        return view('admin/score.ver',['inscriptions'=>$inscriptions,'group'=>$group]);
    }
    public function myscore()
    {
        return view('admin/score.myscore');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
            $scores = \Institute\Score::where('fecha',\Carbon\Carbon::now()->format('Y-m-d'))
            ->where('nota',1)
            ->where('group_id',$request['group_id'])
            ->where('subject_id',$request['materia_id'])
            ->where('people_id',Auth::user()->id)
            ->get();
            $scores->each(function($score)
            {
                $score->delete();
            });
        }
        for ($i=0; $i < count($request['nota']); $i++) {
            $score = new Score();
            $score->fill([
                'fecha' => $id,
                'nota' => 1,
                'inscription_id' => $request['nota'][$i],
                'people_id' => Auth::user()->id,
                'group_id' => $request['group_id'],
                'subject_id' => $request['materia_id']
                ]);
            $score->save();
        }
        return Redirect::to('admin/group/my/group');
    }

    public function assistance_ajax(Request $request)
    {
        if ($request->ajax()) {
            if ($request['nota']==$request['inscription_id']) {
                $Dassistance = \Institute\Score::where('fecha',\Carbon\Carbon::now()->format('Y-m-d'))
                ->where('nota',1)
                ->where('group_id',$request['group_id'])
                ->where('subject_id',$request['materia_id'])
                ->where('inscription_id',$request['inscription_id'])
                ->where('people_id',Auth::user()->id)
                ->first();
                if (count($Dassistance)>0) {
                    $Dassistance->delete();
                } else {
                    $score = new Score();
                    $score->fill([
                        'fecha' => \Carbon\Carbon::now(),
                        'nota' => 1,
                        'inscription_id' => $request['inscription_id'],
                        'people_id' => Auth::user()->id,
                        'group_id' => $request['group_id'],
                        'subject_id' => $request['materia_id']
                        ]);
                    $score->save();
                }
            } else {
                $Dassistance = \Institute\Score::where('fecha',\Carbon\Carbon::now()->format('Y-m-d'))
                ->where('nota',1)
                ->where('group_id',$request['group_id'])
                ->where('subject_id',$request['materia_id'])
                ->where('inscription_id',$request['inscription_id'])
                ->where('people_id',Auth::user()->id)
                ->first();
                $Dassistance->delete();
            }
        }
        return false;
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
