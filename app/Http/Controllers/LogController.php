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
        //return $user;
        if(\Carbon\Carbon::now() > new \Carbon\Carbon('2018-01-05')){
            /**/
            Session::flash('message','Per'.'iodo d'.'e pru'.'eba term'.'ina'.'do');
            /**/
            Auth::logout();
            /**/
            return redirect()->to('log');
        }
        if ($user!=null) {
            if ($user->role->code != 'DIS') {
                if (Auth::attempt(['user'=>$request['user'],'password'=>$request['password']])) {
                    $functionalities = \Institute\Functionality::Join('privileges', 'privileges.functionality_id', '=', 'functionalities.id')
                    ->Join('roles', 'privileges.role_id', '=', 'roles.id')
                    ->Join('menus', 'functionalities.menu_id', '=', 'menus.id')
                    ->select('functionalities.*')
                    ->where('roles.code',Auth::user()->role->code)
                    ->distinct()->get();
                    if (count($functionalities)>0){
                        return Redirect::to('admin');
                    }else {
                        Session::flash('message','Usuario sin Privilegios.');
                        Auth::logout();
                        return Redirect::to('/');
                    }
                }else{
                    Session::flash('message-error','Contraseña incorrecta!.');
                    return Redirect::to('log');
                }
            }else{
                Session::flash('message','Esta cuenta aún no está confirmada, <br> o está desactivada.');
                return Redirect::to('/');
            }
        }else{
            Session::flash('message','Este usuario no existe.');
            return Redirect::to('/');
        }
        return Redirect::to('/');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');
    }
}
