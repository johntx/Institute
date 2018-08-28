<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Income;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class IncomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->income = Income::find($route->getParameter('income'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role->code=='ADM' || Auth::user()->role->code=='ROOT') {
            $incomes = Income::orderBy('id','DESC')->paginate(20);
        } else {
            $incomes = Income::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(20);
        }
        return view('admin/income.index',compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = \Institute\Item::join('careers','items.career_id','=','careers.id')
        ->select('items.*')
        ->orderBy('careers.nombre','asc')
        ->get();
        return view('admin/income.create',['items'=>$items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $col = collect();
        $sub=0;
        for ($i=0; $i < count($request['item']); $i++) {
            if ($request['cantidad'][$i]>0) {
                $itm = \Institute\Item::find($request['item'][$i]);
                $list = new \Institute\Incomelist;
                $list->cantidad = $request['cantidad'][$i];
                $list->item_id = $request['item'][$i];
                $col->push($list);
                $suma = ($itm->costo*$request['cantidad'][$i]);
                $sub+=$suma;
                $itm->stock+=$request['cantidad'][$i];
                $itm->save();
            }
        }
        $income = new Income;
        $income->fill([
            'fecha' => \Carbon\Carbon::now(),
            'detalle' => $request['detalle'],
            'total' => $sub,
            'user_id' => Auth::user()->id
            ]);
        $income->save();
        $income->incomelists()->saveMany($col);
        Session::flash('success','Ingreso de Item registrado exitosamente');
        Session::flash('pdf','admin/income/pdf/'.$income->id);
        return Redirect::to('admin/income/create');
    }

    public function pdf($id)
    {
        $income = Income::find($id);
        $view =  view('pdf/PDFComprobante', ['income'=>$income])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a5', 'landscape');
        return $pdf->stream('comprobante '.$income->nombre.'.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/income.delete',['income'=>$this->income]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = \Institute\Item::all();
        return view('admin/income.edit',['income'=>$this->income,'items'=>$items]);
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
        $this->income->fill($request->all());
        $this->income->save();
        Session::flash('success','Ingreso de Item editada exitosamente');
        return Redirect::to('/admin/income');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->id==$this->income->user_id) {
            $this->income->incomelists->each(function($incomelist){
                $itm = \Institute\Item::find($incomelist->item_id);
                $itm->stock-=$incomelist->cantidad;
                $itm->save();
                $incomelist->delete();
            });
            $this->income->delete();
            Session::flash('success','Ingreso de Item borrada exitosamente');
        } else {
            Session::flash('error','Usted no puede realizar esta operacion');
        }
        return Redirect::to('/admin/income');
    }
}
