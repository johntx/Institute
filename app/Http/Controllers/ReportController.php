<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\People;
use Illuminate\Routing\Route;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['index','create','edit','show']]);
        $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
    }
    public function find(Route $route)
    {
        $this->menu = Menu::find($route->getParameter('menu'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function debit()
    {
        $fecha_semana = date('Y-m-d',strtotime('-1 month', strtotime(\Carbon\Carbon::now()) ));
        $fecha_mes = date('Y-m-d',strtotime('+1 week', strtotime(\Carbon\Carbon::now()) ));
        $payments = \Institute\Payment::
        join('inscriptions','payments.inscription_id','=','inscriptions.id')
        ->where('payments.estado','Pendiente')
        ->where('inscriptions.estado','Inscrito')
        ->whereBetween('fecha_pagar', array( $fecha_semana, $fecha_mes))
        ->orderBy('fecha_pagar','ASC')
        ->get();
        return view('admin/report.debit',['payments'=>$payments]);
    }

    public function groups()
    {
        $fecha_semana = date('Y-m-d',strtotime('+1 month', strtotime(\Carbon\Carbon::now()) ));
        $fecha_mes = date('Y-m-d',strtotime('-1 week', strtotime(\Carbon\Carbon::now()) ));
        $startclasses = \Institute\Startclass::
        whereBetween('fecha_inicio',array( $fecha_mes, $fecha_semana))
        ->get();
        return view('admin/report.groups',['startclasses'=>$startclasses]);
    }

    public function debitByGroups()
    {
        $startclasses = \Institute\Startclass::
        orderBy('startclasses.id','desc')
        ->get();
        return view('admin/report.debitByGroups',['startclasses'=>$startclasses]);
    }
    public function payments()
    {
        $startclasses = \Institute\Startclass::
        orderBy('startclasses.id','desc')
        ->get();
        return view('admin/report.payments',['startclasses'=>$startclasses]);
    }
}
