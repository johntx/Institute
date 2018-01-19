<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\People;
use Illuminate\Routing\Route;
use DB;
use Carbon\Carbon;
use Institute\Payment;

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
        $fecha_semana = date('Y-m-d',strtotime('-1 month', strtotime(Carbon::now()) ));
        $fecha_mes = date('Y-m-d',strtotime('+1 week', strtotime(Carbon::now()) ));
        $payments = Payment::
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
        $startclasses = \Institute\Startclass::
        join('careers','startclasses.career_id','=','careers.id')
        ->select('startclasses.*')
        ->where('startclasses.estado','!=','Cerrado')
        ->orderBy('careers.nombre')
        ->get();
        return view('admin/report.groups',['startclasses'=>$startclasses]);
    }
    public function group($id)
    {
        $startclass = \Institute\Startclass::find($id);
        return view('admin/report.group',['startclass'=>$startclass]);
    }

    public function debitByGroups()
    {
        $startclasses = \Institute\Startclass::
        join('careers','startclasses.career_id','=','careers.id')
        ->select('startclasses.*')
        ->where('startclasses.estado','!=','Cerrado')
        ->orderBy('careers.nombre')
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
    public function incomeByEmployee($fecha_inicio = '', $fecha_fin = '')
    {
        if ($fecha_inicio == '') {
            $fecha_inicio = Carbon::now()->format('Y-m-d');
        }
        if ($fecha_fin == '') {
            $fecha_fin = Carbon::now()->format('Y-m-d');
        }
        $users = \Institute\User::
        join('payments','payments.user_id','=','users.id')
        ->select('users.*')
        ->where('payments.estado','Pagado')
        ->distinct()
        ->get();
        return view('admin/report.incomeByEmployee',['users'=>$users, 'fecha_inicio'=>$fecha_inicio, 'fecha_fin'=>$fecha_fin]);
    }

    public function getchartmensualdesc(Request $request,$inicio,$fin)
    {
        $fechaMesAntes = Carbon::parse($inicio);
        $fechaMesAntes->subMonth();
        $inidate = Carbon::parse($inicio);
        $findate = Carbon::parse($fin)->addMonth();
        $fecha_inicio = Carbon::parse($inicio)->subMonth();
        $fecha_inicio->day(1);
        $listaIngresos = collect([$this->getMes($fecha_inicio)=>0]);

        for ($i=0; $i <= $fechaMesAntes->diffInMonths($findate); $i++) {
            $suma = 0;
            $sumaSiguiente = 0;
            $fecha_fin = Carbon::parse($fecha_inicio)->addMonth();
            $fecha_fin->day(1);
            $fecha_fin->subDay();
            foreach (Payment::where('estado','Pagado')->whereBetween('fecha_pago',array( $fecha_inicio, $fecha_fin))->get() as $key=>$payment) {
                $fecha_pago = Carbon::parse($payment->fecha_pago);
                $fecha_siguiente = Carbon::parse($fecha_pago);
                $fecha_siguiente->addMonth();

                $fecha_fin_mes = Carbon::parse($fecha_pago);
                $fecha_fin_mes->addMonth();
                $fecha_fin_mes->day(1);
                $fecha_fin_mes->subDay();

                $diffTodoElMes = $fecha_pago->diffInDays($fecha_siguiente);
                $diffDias = $fecha_pago->diffInDays($fecha_fin_mes);
                $diffDiasSigMes =  $diffTodoElMes-$diffDias;
                $abono=$payment->abono;
                $abonopordia = $abono/$diffTodoElMes;
                $ingresoEsteMes = $abonopordia*$diffDias;
                $ingresoSiguienteMes = $abono-$ingresoEsteMes;
                $suma += $ingresoEsteMes;
                $sumaSiguiente += $ingresoSiguienteMes;
            }

            $mes = $this->getMes($fecha_inicio);
            $mesmasuno = Carbon::parse($fecha_inicio)->addMonth();
            $nomNextMes=$this->getMes($mesmasuno);
            $array = array('mes'=>$mes,'ingreso'=>$suma);
            $array2 = array('mes'=>$nomNextMes,'ingreso'=>$sumaSiguiente);

            $listaIngresos[$mes] = $listaIngresos[$mes] + $suma;
            $listaIngresos->put($nomNextMes,$sumaSiguiente);
            $fecha_inicio->addMonth();
        }
        $listaIngresos->shift();
        $listaIngresos->pop();
        return $listaIngresos;
    }

    public function getchartmensual(Request $request,$inicio,$fin)
    {
        if ($request->ajax()) {
            $fechaMesAntes = Carbon::parse($inicio)->day(1)->subMonth();
            $findate = Carbon::parse($fin)->day(1)->addMonth();
            $fecha_inicio = Carbon::parse($inicio)->day(1)->subMonth();
            $listaIngresos = collect([$this->getMes($fecha_inicio)=>0]);

            for ($i=0; $i <= $fechaMesAntes->diffInMonths($findate); $i++) {
                $suma = 0;
                $sumaSiguiente = 0;
                $fecha_fin = Carbon::parse($fecha_inicio)->addMonth();
                $fecha_fin->day(1);
                $fecha_fin->subDay();
                foreach (Payment::where('estado','Pagado')->whereBetween('fecha_pago',array( $fecha_inicio, $fecha_fin))->get() as $key=>$payment) {
                    $fecha_pago = Carbon::parse($payment->fecha_pago);
                    $fecha_siguiente = Carbon::parse($fecha_pago);
                    $fecha_siguiente->addMonth();

                    $fecha_fin_mes = Carbon::parse($fecha_pago);
                    $fecha_fin_mes->addMonth();
                    $fecha_fin_mes->day(1);
                    $fecha_fin_mes->subDay();

                    $diffTodoElMes = $fecha_pago->diffInDays($fecha_siguiente);
                    $diffDias = $fecha_pago->diffInDays($fecha_fin_mes);
                    $diffDiasSigMes =  $diffTodoElMes-$diffDias;
                    $abono=$payment->abono;
                    $abonopordia = $abono/$diffTodoElMes;
                    $ingresoEsteMes = $abonopordia*$diffDias;
                    $ingresoSiguienteMes = $abono-$ingresoEsteMes;
                    $suma += $ingresoEsteMes;
                    $sumaSiguiente += $ingresoSiguienteMes;
                }

                $payment = Payment::select(DB::raw('sum(payments.abono) as suma'))->where('observacion','Pagado al Contado')->whereBetween('fecha_pago',array( $fecha_inicio, $fecha_fin))->first();
                if ($payment) {
                    $suma +=$payment->suma;
                }

                $mes = $this->getMes($fecha_inicio);
                $mesmasuno = Carbon::parse($fecha_inicio)->addMonth();
                $nomNextMes=$this->getMes($mesmasuno);
                $array = array('mes'=>$mes,'ingreso'=>$suma);
                $array2 = array('mes'=>$nomNextMes,'ingreso'=>$sumaSiguiente);

                $listaIngresos[$mes] = $listaIngresos[$mes] + $suma;
                $listaIngresos->put($nomNextMes,$sumaSiguiente);
                $fecha_inicio->addMonth();
            }
            $listaIngresos->shift();
            $listaIngresos->pop();
            $listaIngresos->pop();

            return response()->json($listaIngresos);
        }
    }
    public function getMes($mes)
    {
        $mes = $mes->format("F");
        if ($mes=="January") $mes="Enero";
        if ($mes=="February") $mes="Febrero";
        if ($mes=="March") $mes="Marzo";
        if ($mes=="April") $mes="Abril";
        if ($mes=="May") $mes="Mayo";
        if ($mes=="June") $mes="Junio";
        if ($mes=="July") $mes="Julio";
        if ($mes=="August") $mes="Agosto";
        if ($mes=="September") $mes="Setiembre";
        if ($mes=="October") $mes="Octubre";
        if ($mes=="November") $mes="Noviembre";
        if ($mes=="December") $mes="Diciembre";
        return $mes;
    }
}
