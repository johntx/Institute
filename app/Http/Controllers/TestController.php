<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Test;
use Institute\Career;
use Illuminate\Routing\Route;
use Validator;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show','create_test']]);
    }
    public function find(Route $route)
    {
        $this->test = Test::find($route->getParameter('test'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $careers = \Institute\Career::get();
        return view('admin/test.index',['careers'=>$careers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $careers = \Institute\Career::lists('nombre', 'id');
        $subjects = \Institute\Subject::lists('nombre', 'id');
        return view('admin/test.create',['careers'=>$careers,'subjects'=>$subjects]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['nombre']=strtoupper($request['nombre']);
        Test::create($request->all());
        Session::flash('success','Asignatura registrado exitosamente');
        return Redirect::to('/admin/test');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $career = \Institute\Career::find($id);
        return view('admin/test.show',['test'=>$this->test,'career'=>$career]);
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
        return view('admin/test.edit',['test'=>$this->test,'career'=>$career, 'subject'=>$subject]);
    }
    public function create_test($id, $subject = '')
    {
        $career = Career::find($id);
        if ($subject == '') {
            $subject = $career->subjects->first();
        } else {
            $subject = \Institute\Subject::where('nombre',$subject)->first();
        }
        return view('admin/test.edit',['test'=>$this->test,'career'=>$career, 'subject'=>$subject]);
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
        $career = Career::find($request['career_id']);
        $subject = \Institute\Subject::find($request['subject_id']);
        if (count($request['modulo']) != count($request['nombre'])) {
            Session::flash('error','No Guardado!');
            return Redirect::to('/admin/test/create/career/'.$career->id.'/'.$subject->nombre);
        }
        $career->tests()->where('subject_id',$request['subject_id'])->get()->each(function ($test){$test->delete();});
        for ($i=0; $i < count($request['nombre']); $i++) {
            $test = new Test;
            $test->fill([
                'id' => $request['id_test'][$i],
                'nombre' => strtoupper($request['nombre'][$i]),
                'orden' => $request['orden'][$i],
                'subject_id' => $request['subject_id'],
                'modulo' => $request['modulo'][$i],
                'career_id' => $request['career_id']
                ]);
            $test->save();
        }
        Session::flash('success','Registro "'.$subject->nombre.'" Guardado Exitosamente');
        return Redirect::to('/admin/test/create/career/'.$career->id.'/'.$subject->nombre);
        return Redirect::to('/admin/test');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->test->delete();
        Session::flash('success','Asignatura borrado exitosamente');
        return Redirect::to('/admin/test');
    }
}
