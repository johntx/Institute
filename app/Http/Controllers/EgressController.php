<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Egress;
use Institute\People;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class EgressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->egress = Egress::find($route->getParameter('egress'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $egresses = Egress::orderBy('id','DESC')->paginate(20);
        return view('admin/egress.index',compact('egresses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/egress.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $egress = new Egress;
        $egress->fill([
            'fecha' => \Carbon\Carbon::now(),
            'glosa' => $request['glosa'],
            'monto' => $request['monto'],
            'codigo' => $request['codigo'],
            'tipo' => $request['tipo'],
            'user_id' => Auth::user()->id
            ]);
        $egress->save();
        Session::flash('message','Egreso registrado exitosamente');
        return Redirect::to('/admin/egress');
    }

    public function savepayment(Request $request)
    {
        $egress = new Egress;
        $egress->fill([
            'fecha' => \Carbon\Carbon::now(),
            'glosa' => $request['glosa'],
            'monto' => $request['monto'],
            'tipo' => $request['tipo'],
            'people_id' => $request['people_id'],
            'user_id' => Auth::user()->id
            ]);
        $egress->save();
        Session::flash('message','Pago registrado exitosamente');
        return Redirect::to('/admin/egress/employees');
    }

    public function pdf($id)
    {
        $egress = Egress::find($id);
        $view =  view('pdf/PDFComprobante', ['egress'=>$egress])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('comprobante '.$egress->glosa.'.pdf');
    }

    public function employees()
    {
        $employees = People::join('users','peoples.id','=','users.id')
        ->join('roles','users.role_id','=','roles.id')
        ->select('peoples.*')
        ->where('roles.code','!=','EST')
        ->where('roles.code','!=','ROOT')
        ->where('roles.code','!=','DIS')
        ->orderBy('roles.id','DESC')
        ->paginate(20);
        return view('admin/egress.employees',compact('employees'));
    }

    public function paymentform($id)
    {
        $employee=People::find($id);
        return view('admin/egress.paymentform',['employee'=>$employee]);
    }

    public function mypayment($id)
    {
        $employee=People::find($id);
        $egresses = Egress::where('people_id',$id)
        ->orderBy('fecha','desc')
        ->get();
        return view('admin/egress.mypayment',['employee'=>$employee, 'egresses'=>$egresses]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/egress.delete',['egress'=>$this->egress]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin/egress.edit',['egress'=>$this->egress]);
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
        $this->egress->fill([
            'fecha' => \Carbon\Carbon::now(),
            'glosa' => $request['glosa'],
            'monto' => $request['monto'],
            'codigo' => $request['codigo'],
            'tipo' => $request['tipo'],
            'user_id' => Auth::user()->id
            ]);
        $this->egress->save();
        Session::flash('message','Egreso editado exitosamente');
        return Redirect::to('/admin/egress');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->egress->delete();
        Session::flash('message','Egreso borrado exitosamente');
        return Redirect::to('/admin/egress');
    }
}
