<?php

namespace App\Garages\Illuminate\Routing;

use Illuminate\Routing\RouteParameterBinder as BaseRouteParameterBinder;

class RouteParameterBinder extends BaseRouteParameterBinder
{
    /**
     * @inheritDoc
     */
    protected function bindHostParameters($request, $parameters)
    {
        preg_match($this->route->compiled->getHostRegex(), $request->getHttpHost(), $matches);

        return array_merge($this->matchToKeys(array_slice($matches, 1)), $parameters);
    }
}
