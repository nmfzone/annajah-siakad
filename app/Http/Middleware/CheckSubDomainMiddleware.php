<?php

namespace App\Http\Middleware;

use App\Models\Site;
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
        /** @var \App\Models\Site|null $site */
        $site = Site::where('domain', $request->getHttpHost())->first();

        if ($site) {
            app()->extend('site', function () use ($site) {
                return $site;
            });

            return $next($request);
        }

        abort(404);
    }
}
