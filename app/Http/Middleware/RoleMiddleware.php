<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $roles
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$roles)
    {
        return app(Authenticate::class)->handle($request, function ($request) use ($next, $roles) {
            if (in_array(Auth::user()->role, $roles)) {
                return $next($request);
            }

            abort(403);
        });
    }
}
