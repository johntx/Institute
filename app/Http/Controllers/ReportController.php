<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\People;
use Institute\Ingreso;
use Institute\Income;
use Institute\Egress;
use Illuminate\Routing\Route;
use DB;
use Carbon\Carbon;
use Institute\Payment;
use Auth;

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
    public function income()
    {
        $startclasses = \Institute\Startclass::
        orderBy('startclasses.id','desc')
        ->get();
        return view('admin/report.income',['startclasses'=>$startclasses]);
    }
    public function students()
    {
        $students = People::join('users','peoples.id','=','users.id')
        ->join('roles','users.role_id','=','roles.id')
        ->join('inscriptions','peoples.id','=','inscriptions.people_id')
        ->join('groups','inscriptions.group_id','=','groups.id')
        ->join('startclasses','groups.startclass_id','=','startclasses.id')
        ->join('careers','startclasses.career_id','=','careers.id')
        ->select('peoples.*','careers.nombre as carrera')
        ->where('roles.code','EST')
        ->where('peoples.office_id',Auth::user()->people->office_id)
        ->orderBy('careers.id','DESC')->get();
        $careers = \Institute\Career::
        select('careers.*')
        ->join('startclasses','careers.id','=','startclasses.career_id')
        ->join('groups','startclasses.id','=','groups.startclass_id')
        ->join('inscriptions','groups.id','=','inscriptions.group_id')
        ->where('inscriptions.estado','Inscrito')
        ->distinct('careers.id')->get();
        return view('admin/report.students',['students'=>$students, 'careers'=>$careers]);
    }
    public function incomeByEmployee($fecha_inicio = '', $fecha_fin = '')
    {
        if ($fecha_inicio == '' || $fecha_inicio == 'fecha') {
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

    public function chart(Request $request,$inicio,$fin)
    {
        if ($request->ajax()) {
            $fechaMesAntes = Carbon::parse($inicio)->day(1)->subMonth();
            $findate = Carbon::parse($fin)->day(1)->addMonth();
            $fecha_inicio = Carbon::parse($inicio)->day(1)->subMonth();
            $col = collect();
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

                $mesmasuno = Carbon::parse($fecha_inicio)->addMonth();
                
                if (sizeof($col)!=0) {
                    $ingreso = new Ingreso;
                    $ingreso->ingreso = $suma;
                    $col->push($ingreso);
                }
                $ingreso = new Ingreso;
                $ingreso->ingreso = $sumaSiguiente;
                $col->push($ingreso);
                $fecha_inicio->addMonth();
            }
            $col2 = collect();
            $fecha = Carbon::parse($inicio)->day(1);
            for ($j=0; $j < sizeof($col)/2 +1; $j++){
                $col[$j]['ingreso']=$col[$j]['ingreso']+$col[$j+1]['ingreso'];
                $ingreso = new Ingreso;
                $ingreso->ingreso = $col[$j]['ingreso'];
                $ingreso = $this->egresos($ingreso,$fecha->format('Y-m-d'));
                $fecha->addMonth();
                $col2->push($ingreso);
                $j++;
            }
            return $col2;
        }
    }

    public function egresos($ingreso,$fecha)
    {
        $fin = Carbon::parse($fecha)->addMonth()->subDay()->format("Y-m-d");
        $suma=0;
        foreach (Income::whereBetween('fecha',array( $fecha, $fin))->get() as $income) {
            $suma+=$income->total;
        }
        foreach (Egress::whereBetween('fecha',array( $fecha, $fin))->get() as $egress) {
            $suma+=$egress->monto;
        }
        $ingreso->egreso = $suma;
        $ingreso->fecha = $fecha;
        $ingreso->fin = $fin;
        $ingreso->total = $ingreso->ingreso -$ingreso->egreso;
        return $ingreso;
    }
}
