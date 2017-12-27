<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\People;
use Institute\User;
use Institute\Inscription;
use Illuminate\Routing\Route;
use Validator;
use Auth;

class InscriptionController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('admin',['only' => ['index','create','edit','show']]);
    $this->beforeFilter('@find',['only' => ['edit','update','destroy','show']]);
  }
  public function find(Route $route)
  {
    $this->inscription = Inscription::find($route->getParameter('inscription'));
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $peoples = People::
      join('inscriptions','peoples.id','=','inscriptions.people_id')
      ->select('peoples.*')
      ->distinct()
      ->get();
      return view('admin/inscription.index',['peoples'=>$peoples]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $students = People::
      join('inscriptions','peoples.id','=','inscriptions.people_id')
      ->select('peoples.*')
      ->distinct()
      ->get();
      $startclasses = \Institute\Startclass::
      where('startclasses.estado','!=','Cerrado')
      ->orderBy('startclasses.fecha_inicio','DESC')
      ->get();
      return view('admin/inscription.create',['startclasses'=>$startclasses,'students'=>$students]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if (Auth::user()->role->code=='ROOT' || Auth::user()->role->code=='ADM') {
        Session::flash('message','Este usuario no puede realizar esta función');
        return Redirect::to('/admin/inscription');
      }
      $validator = Validator::make($request->all(), [
        'user_id' => 'required:peoples'
        ]);

      if ($validator->fails()) {
        return redirect('/admin/inscription/create')
        ->withErrors($validator)
        ->withInput();
      }
      $group=\Institute\Group::find($request['group_id']);
      $total = 0;
      if ($group->startclass->career->mes > 0) {
        $total = $request['monto']*$group->startclass->career->mes;
      } else {
        $total = $request['monto'];
      }
      if ($request['abono'] > $total) {
        return redirect('/admin/inscription/create')
        ->withErrors('Monto superior al total');
      }
      if ($request['abono'] > $request['monto'] && $request['abono'] != $total) {
        return redirect('/admin/inscription/create')
        ->withErrors('Monto superior al pago mensual, realize un pago igual al monto mensual y realize un nuevo pago para cada mensualidad, o haga el pago total de la colegiatura');
      }
      $inscription = new Inscription;
      if ($request['abono'] == $total) {
        $colegiatura = 'Pagado';
      }
      if ($request['abono'] < $total) {
        $colegiatura = 'Debe';
      }
      $people= People::find($request['user_id']);
      $startclass = \Institute\Startclass::find($request['startclass_id']);
      $inscription->fill([
        'estado' => 'Inscrito',
        'people_id' => $people->id,
        'monto' => $request['monto'],
        'abono' => $request['abono'],
        'total' => $total,
        'colegiatura' => $colegiatura,
        'career_id' => $startclass->career->id,
        'group_id' => $request['group_id'],
        'user_id' => Auth::user()->id
        ]);
      $inscription->save();

      if ($request['abono'] == $total) {
        $payment = new \Institute\Payment;
        $payment->fill([
          'fecha_pagar' => $group->startclass->fecha_inicio,
          'estado' => 'Pagado',
          'abono' => $request['abono'],
          'saldo' => $total,
          'inscription_id' => $inscription->id,
          'user_id' => Auth::user()->id
          ]);
        $payment->save();
      } else {
        $saldo = 0;
        if ($request['abono'] < $request['monto']) {
          $saldo = $request['monto']-$request['abono'];
          $fecha_pagar = date('Y-m-d',strtotime('+1 week', strtotime($group->startclass->fecha_inicio)));
        }
        if ($request['abono'] == $request['monto']) {
          $fecha_pagar = date('Y-m-d',strtotime('+1 month', strtotime($group->startclass->fecha_inicio)));
          $saldo = $request['monto'];
        }
        $payment = new \Institute\Payment;
        $payment->fill([
          'fecha_pagar' => $group->startclass->fecha_inicio,
          'fecha_pago' => \Carbon\Carbon::now(),
          'estado' => 'Pagado',
          'abono' => $request['abono'],
          'saldo' => $request['monto'],
          'inscription_id' => $inscription->id,
          'user_id' => Auth::user()->id
          ]);
        $payment->save();
        $payment2 = new \Institute\Payment;
        $payment2->fill([
          'fecha_pagar' => $fecha_pagar,
          'estado' => 'Pendiente',
          'abono' => 0,
          'saldo' => $saldo,
          'inscription_id' => $inscription->id,
          'user_id' => Auth::user()->id
          ]);
        $payment2->save();
      }
      Session::flash('message','Estudiante registrado exitosamente');
      return Redirect::to('/admin/inscription');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $this->inscription->estado='Retirado';
      $this->inscription->save();
      Session::flash('message','Estudiante Retirado exitosamente');
      return Redirect::to('/admin/report/debit');
    }
  }
