<?php

namespace App\Http\Middleware;

use App\Envato\Envato;
use Closure;
use HP;

class CheckVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
