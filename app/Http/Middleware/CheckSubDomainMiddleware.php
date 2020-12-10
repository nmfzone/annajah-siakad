<?php

namespace App\Http\Middleware;

use Closure;

class CheckSubDomainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (app()->has('site')) {
            return $next($request);
        }

        abort(404);
    }
}
