<?php

namespace App\Http\Middleware;

use Closure;

class SubPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return app(Authenticate::class)->handle($request, function ($request) use ($next) {
            if (auth()->user()->isSuperAdmin() && is_main_app()) {
                return $next($request);
            }

            $site = site();

            if (auth()->user()->isSuperAdmin() ||
                ($site && $site->users()->find(auth()->user()))) {
                return $next($request);
            }

            abort(403);
        });
    }
}
