<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Exam;
use Institute\ExamSubject;
use Institute\Career;
use Illuminate\Routing\Route;
use Validator;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show','create_exam']]);
    }
    public function find(Route $route)
    {
        $this->exam = Exam::find($route->getParameter('exam'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $careers = \Institute\Career::get();
        return view('admin/exam.index',['careers'=>$careers]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $career = \Institute\Career::find($id);
        $subject = $career->subjects->first();
        return view('admin/exam.edit',['exam'=>$this->exam,'career'=>$career, 'subject'=>$subject]);
    }
    public function create_exam($id, $subject = '')
    {
        $career = Career::find($id);
        if ($subject == '') {
            $subject = $career->subjects->first();
        } else {
            $subject = \Institute\Subject::where('nombre',$subject)->first();
        }
        return view('admin/exam.edit',['exam'=>$this->exam,'career'=>$career, 'subject'=>$subject]);
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
        if (count($request['correcta']) != count($request['pregunta'])) {
            Session::flash('error','No Guardado!. Hay respuestas sin marcado correcto');
            return Redirect::to('/admin/exam');
        }
        $career = Career::find($request['career_id']);
        $subject = \Institute\Subject::find($request['subject_id']);
        $career->exam_subjects()->where('subject_id',$request['subject_id'])->get()->each(function ($exam_subject){
            $exam_subject->exam->delete();
        });
        for ($i=0; $i < count($request['pregunta']); $i++) {
            $exam = new Exam;
            $exam->fill([
                'pregunta' => strtoupper($request['pregunta'][$i]),
                'respuesta1' => $request['respuesta1'][$i],
                'respuesta2' => $request['respuesta2'][$i],
                'respuesta3' => $request['respuesta3'][$i],
                'respuesta4' => $request['respuesta4'][$i],
                'respuesta5' => $request['respuesta5'][$i],
                'correcta' => $request['correcta'][$i]
                ]);
            $exam->save();
            $examSubject = new ExamSubject;
            $examSubject->fill([
                'subject_id' => $request['subject_id'],
                'exam_id' => $exam->id,
                'career_id' => $request['career_id']
                ]);
            $examSubject->save();
        }
        Session::flash('success','Registro Guardado Exitosamente');
        return Redirect::to('/admin/exam/create/career/'.$career->id.'/'.$subject->nombre);
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
