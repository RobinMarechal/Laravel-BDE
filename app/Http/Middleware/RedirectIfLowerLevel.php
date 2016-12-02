<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Redirect;

class RedirectIfLowerLevel
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
    public function handle($request, Closure $next, $levelMin=1)
    {
        if($this->auth->user()->level < $levelMin)
        {
            Flash::error("Vous n'avez pas le droit d'effectuer ceci.");
            return Redirect::back();
        }
        return $next($request);
    }
}
