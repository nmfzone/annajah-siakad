<?php

namespace App\Http\Middleware;

use App\Models\Site;
use Closure;

class SetSiteMiddleware
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
            app()->singleton('site', function () use ($site) {
                return $site;
            });
        }

        return $next($request);
    }
}
