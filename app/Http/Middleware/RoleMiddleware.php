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
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$roles)
    {
        return app(Authenticate::class)->handle($request, function ($request) use ($next, $roles) {
            if (in_array(auth()->user()->role, $roles)) {
                return $next($request);
            }

            return abort(403);
        });
    }
}
