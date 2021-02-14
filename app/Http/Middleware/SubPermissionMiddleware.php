<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
            $authUser = Auth::user();

            if ($authUser->isSuperAdmin() && is_main_app()) {
                return $next($request);
            }

            $site = site();

            if ($authUser->isSuperAdmin() || ($site && $site->users()->find($authUser))) {
                return $next($request);
            }

            abort(403);
        });
    }
}
