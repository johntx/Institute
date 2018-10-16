<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Institute\Startclass;
use Institute\Bot;
use Carbon\Carbon;
use Mail;
use Auth;

class FrontController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth',['only' => ['admin']]);
    $this->middleware('admin',['only' => ['admin']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('web/cien/index');
  }
  public function admin()
  {
    $role = Auth::user()->role->name;
    if ($role != 'EST' && $role != 'DOC' && $role != 'EXT') {
      $this->iemployee();
    }
    return view('admin/index');
  }
  public function iemployee()
  {
    $bot_grupos = Bot::find(1);
    $bot_faltas = Bot::find(2);
    $fecha_hoy = \Carbon\Carbon::now()->format('Y-m-d');
    if ($bot_grupos->fecha!=$fecha_hoy) {
      $this->BotGrupos($bot_grupos);
    }
    if ($bot_faltas->fecha!=$fecha_hoy) {
      $this->BotFaltas($bot_faltas);
    }
  }
  public function BotGrupos($bot_grupos)
  {
    $fecha_despues = date('Y-m-d',strtotime('+1 month', strtotime(Carbon::now()) ));
    $fecha_antes = date('Y-m-d',strtotime('-1 month', strtotime(Carbon::now()) ));
    $startclasses = Startclass::whereBetween('fecha_fin',array( $fecha_antes, $fecha_despues))
    ->orWhereBetween('fecha_inicio',array( $fecha_antes, $fecha_despues))
    ->get();
    foreach ($startclasses as $startclass) {
      if (Carbon::now()->format('Y-m-d') <= $startclass->fecha_fin) {
        if (Carbon::now()->format('Y-m-d') <= $startclass->fecha_inicio) {
          if ($startclass->estado != 'Espera') {
            $inscription->update(['estado' => 'Espera']);
          }
        } else {
          if ($startclass->estado != 'Iniciado') {
            $inscription->update(['estado' => 'Iniciado']);
          }
        }
        /*Inscripciones*/
        foreach ($startclass->groups  as $group) {
          foreach ($group->inscriptions as $inscription) {
            if ($inscription->estado != 'Inscrito' && $inscription->estado != 'Retirado') {
            $inscription->update(['estado' => 'Inscrito']);
            }
          }
        }
      } else {
        if ($startclass->estado != 'Cerrado') {
            $inscription->update(['estado' => 'Cerrado']);
        }
        /*Inscripciones*/
        foreach ($startclass->groups  as $group) {
          foreach ($group->inscriptions as $inscription) {
            if ($inscription->estado != 'Culminado' && $inscription->estado != 'Retirado') {
            $inscription->update(['estado' => 'Culminado']);
            }
          }
        }
      }
    }
    $bot_grupos->update(['fecha' => \Carbon\Carbon::now()]);
  }
  public function BotFaltas($bot_faltas)
  {
    $inscriptions = \Institute\Inscription::distinct('people_id')->get();
    foreach ($inscriptions as $inscription) {
      if ($inscription->estado != 'Retirado' && $inscription->estado != 'Culminado' && $inscription->group->startclass->career->lista == 'si') {
        if ($inscription->alumno_antiguo()) {
          if ($inscription->asistencias_semana() == 0) {
            /*retirar estudiantes faltones*/
            $inscription->update(['estado' => 'Retirado']);
          }
        }
      }
    }
    $bot_faltas->update(['fecha' => \Carbon\Carbon::now()]);
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

  public function mail(Request $request)
  {
    Mail::send('emails.msg_send', ['msg' => $request], function($message) use ($request) {
      $message->from($request['email'], $request['name']);
      $message->to('informacion@institutocien.com', 'Instituto CIEN')->subject('Envío de Mensaje');
    });
    Mail::send('emails.msg_response', ['user' => $request], function($message) use ($request) {
      $message->from('informacion@institutocien.com', 'Instituto CIEN');
      $message->to($request['email'], $request['name'])->subject('Respuesta automática');
    });
    Session::flash('success','Mensaje enviado con éxito');
    return Redirect::to('/');
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
    /*Startclasses*/
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
