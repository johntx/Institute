<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Order;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->order = Order::find($route->getParameter('order'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role->code == "ADM" || Auth::user()->role->code == "ROOT") {
            $orders = Order::orderBy('id','DESC')->paginate(20);
        } else {
            $orders = Order::where('user_id',Auth::user()->id)->orderBy('id','DESC')->paginate(20);
        }
        return view('admin/order.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $careers = \Institute\Career::join('items','careers.id','=','items.career_id')->select('careers.*')->distinct('careers.id')->get();
        $career = $careers->first();
        $items = \Institute\Item::join('careers','items.career_id','=','careers.id')
        ->select('items.*')
        ->orderBy('careers.nombre','asc')
        ->get();
        return view('admin/order.create',['items'=>$items,'careers'=>$careers, 'career'=>$career]);
    }
    public function create_career($career = '')
    {
        $careers = \Institute\Career::join('items','careers.id','=','items.career_id')->select('careers.*')->distinct('careers.id')->get();
        if ($career == '') {
            $career = $careers->first();
        } else {
            $career = \Institute\Career::where('nombre',$career)->first();
        }
        $items = \Institute\Item::join('careers','items.career_id','=','careers.id')
        ->select('items.*')
        ->orderBy('careers.nombre','asc')
        ->get();
        return view('admin/order.create',['items'=>$items,'careers'=>$careers, 'career'=>$career]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request['people_id']=='') {
            $request['people_id']=null;
        }
        $col = collect();
        $sub=0;
        for ($i=0; $i < count($request['item']); $i++) {
            if ($request['cantidad'][$i]>0) {
                $itm = \Institute\Item::find($request['item'][$i]);
                $list = new \Institute\Buylist;
                $list->cantidad = $request['cantidad'][$i];
                $list->item_id = $request['item'][$i];
                $col->push($list);
                $suma = ($itm->precio*$request['cantidad'][$i]);
                $sub+=$suma;
                $itm->stock-=$request['cantidad'][$i];
                $itm->save();
            }
        }
        $order = new Order;
        $order->fill([
            'nombre' => $request['nombre'],
            'fecha_compra' => \Carbon\Carbon::now(),
            'detalle' => $request['detalle'],
            'subtotal' => $sub,
            'total' => $sub-$request['descuento'],
            'descuento' => $request['descuento'],
            'telefono' => $request['telefono'],
            'people_id' => $request['people_id'],
            'user_id' => Auth::user()->id
            ]);
        $order->save();
        $order->buylists()->saveMany($col);
        Session::flash('pdf','admin/order/pdf/'.$order->id);
        Session::flash('success','Compra registrada exitosamente');
        return Redirect::to('admin/order/create/career/'.$request['career']);
    }

    public function pdf($id)
    {
        $order = Order::find($id);
        $view =  view('pdf/PDFVenta', ['order'=>$order])->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a5', 'landscape');
        return $pdf->stream('recivo '.$order->nombre.'.pdf');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin/order.delete',['order'=>$this->order]);
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
        return view('admin/order.edit',['order'=>$this->order,'items'=>$items]);
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
        $this->order->fill($request->all());
        $this->order->save();
        Session::flash('success','Compra editada exitosamente');
        return Redirect::to('/admin/order');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->order->buylists->each(function($buylist){
            $itm = \Institute\Item::find($buylist->item_id);
            $itm->stock+=$buylist->cantidad;
            $itm->save();
            $buylist->delete();
        });
        $this->order->delete();
        Session::flash('success','Compra borrada exitosamente');
        return Redirect::to('/admin/order');
    }
}
