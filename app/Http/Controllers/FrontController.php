<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;
use Institute\Startclass;
use Carbon\Carbon;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('web/index');
    }
    public function admin()
    {
      /*Startclasses*/
      $fecha_despues = date('Y-m-d',strtotime('+1 month', strtotime(Carbon::now()) ));
      $fecha_antes = date('Y-m-d',strtotime('-1 month', strtotime(Carbon::now()) ));
      $startclasses = Startclass::whereBetween('fecha_fin',array( $fecha_antes, $fecha_despues))
      ->orWhereBetween('fecha_inicio',array( $fecha_antes, $fecha_despues))
      ->get();
      foreach ($startclasses as $startclass) {
        if (Carbon::now()->format('Y-m-d') <= $startclass->fecha_fin) {
          if (Carbon::now()->format('Y-m-d') <= $startclass->fecha_inicio) {
            if ($startclass->estado != 'Espera') {
              $startclass->estado = 'Espera';
              $startclass->save();
            }
          } else {
            if ($startclass->estado != 'Iniciado') {
              $startclass->estado = 'Iniciado';
              $startclass->save();
            }
          }
          /*Inscripciones*/
          foreach ($startclass->groups  as $group) {
            foreach ($group->inscriptions as $inscription) {
              if ($inscription->estado != 'Inscrito' && $inscription->estado != 'Retirado') {
                $inscription->estado = 'Inscrito';
                $inscription->save();
              }
            }
          }
        } else {
          if ($startclass->estado != 'Cerrado') {
            $startclass->estado = 'Cerrado';
            $startclass->save();
          }
          /*Inscripciones*/
          foreach ($startclass->groups  as $group) {
            foreach ($group->inscriptions as $inscription) {
              if ($inscription->estado != 'Culminado' && $inscription->estado != 'Retirado') {
                $inscription->estado = 'Culminado';
                $inscription->save();
              }
            }
          }
        }
      }
      return view('admin/index');
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
