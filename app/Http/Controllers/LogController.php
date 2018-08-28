<?php

namespace Institute\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use Redirect;

use Institute\Http\Requests;
use Institute\Http\Controllers\Controller;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = \Institute\User::where('user', $request['user'])->first();
        if ($user!=null) {
            if ($user->role->code != 'DIS') {
                if (Auth::attempt(['user'=>$request['user'],'password'=>$request['password']])) {
                    $functionalities = Auth::user()->role->functionalities;
                    if (count($functionalities)>0){
                        if (Auth::user()->role->code == 'EST') {
                            if (!Auth::user()->people->inscriptions->where('estado','Inscrito')->first()->debit()) {
                                return Redirect::to('admin/evaluation/create');
                            } else {
                                Session::flash('error','Saldo en su mensualidad. Pasar por secretaría');
                                Auth::logout();
                                return Redirect::to('log');
                            }
                        }
                        return Redirect::to('admin');
                    }else {
                        Session::flush();
                        Session::flash('message_error','Usuario sin Privilegios.');
                        Auth::logout();
                        return Redirect::to('/');
                    }
                }else{
                    Session::flash('error','Contraseña incorrecta!.');
                    return Redirect::to('log');
                }
            }else{
                Session::flash('message_error','Esta cuenta aún no está confirmada, <br> o está desactivada.');
                return Redirect::to('/');
            }
        }else{
            Session::flash('message_error','Este usuario no existe.');
            return Redirect::to('/');
        }
        return Redirect::to('/');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return Redirect::to('/');
    }
}
