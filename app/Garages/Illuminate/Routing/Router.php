<?php

namespace App\Garages\Illuminate\Routing;

use Illuminate\Http\Request;
use Illuminate\Routing\Router as BaseRouter;
use Illuminate\Routing\Route;

class Router extends BaseRouter
{
    /**
     * @inheritDoc
     */
    protected function runRoute(Request $request, Route $route)
    {
        // We need to set the parameters again using our new
        // RouteParameterBinder, since we can't override it directly.
        $route->parameters = (new RouteParameterBinder($route))
            ->parameters($this->container->make('request'));

        return parent::runRoute($request, $route);
    }

    /**
     * Set the middleware.
     *
     * @param  array  $middleware
     * @return void
     */
    public function setMiddleware(array $middleware)
    {
        $this->middleware = $middleware;
    }

    /**
     * Set the middleware groups.
     *
     * @param  array  $middlewareGroups
     * @return void
     */
    public function setMiddlewareGroups(array $middlewareGroups)
    {
        $this->middlewareGroups = $middlewareGroups;
    }
}
