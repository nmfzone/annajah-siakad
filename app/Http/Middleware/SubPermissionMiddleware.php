<?php

namespace App\Http\Middleware;

use App\Enums\Role;
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
            if (! app()->has('site')) {
                return $next($request);
            }

            /** @var \App\Models\Site $site */
            $site = app()->make('site');

            if (auth()->user()->isSuperAdmin() ||
                ($site && $site->users()->find(auth()->user()))) {
                return $next($request);
            }

            return abort(403);
        });
    }
}
