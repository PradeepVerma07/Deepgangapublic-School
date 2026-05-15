<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Schema;

class RouteServe
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
