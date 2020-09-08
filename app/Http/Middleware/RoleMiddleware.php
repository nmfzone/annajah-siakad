<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        foreach($roles as $role) {
            if (auth()->check() && auth()->user()->role == $role) {
                return $next($request);
            }
        }

        return abort(403);
    }
}
