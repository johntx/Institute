<?php

namespace Institute\Http\Middleware;
use Illuminate\Contracts\Auth\Guard;
use Closure;
use Session;
use Auth;

class Admin
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::user()) {
            return redirect()->to('/');
        }
        $functionalities = Session::get('functionalities');
        if (count($functionalities)>0){
            if ($request->path()=='admin'){
                return $next($request);
            } else {
                $path = $request->path();
                $id = intval(preg_replace('/[^0-9]+/', '', $request->path()), 10);
                if (substr($request->path(), strlen($request->path())-4, strlen($request->path()))=='edit') {
                    $path = str_replace($id.'/edit', "edit", $path);
                }
                if (substr($request->path(), strlen($request->path())-strlen($id), strlen($request->path()))==$id) {
                    $path = str_replace($id, "delete", $path);
                }
                $functionality = \Institute\Functionality::Join('privileges', 'privileges.functionality_id', '=', 'functionalities.id')
                ->Join('roles', 'privileges.role_id', '=', 'roles.id')
                ->Join('menus', 'functionalities.menu_id', '=', 'menus.id')
                ->select('functionalities.*')
                ->where('functionalities.path',$path)
                ->where('roles.code',Auth::user()->role->code)
                ->first();
                if (count($functionality)>0 || $request->path()=='admin'){
                    return $next($request);
                } else {
                    Session::flash('message-error','Usuario sin Privilegios');
                    return redirect()->to('admin');
                }
            }
        } else {
            Session::flash('message','Usuario sin Privilegios');
            Auth::logout();
            return redirect()->to('/');
        }
    }
}
