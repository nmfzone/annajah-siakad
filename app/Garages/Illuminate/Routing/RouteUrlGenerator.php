<?php

namespace App\Garages\Illuminate\Routing;

use Illuminate\Routing\RouteUrlGenerator as BaseUrlGenerator;
use Illuminate\Support\Arr;

class RouteUrlGenerator extends BaseUrlGenerator
{
    /**
     * @inheritDoc
     */
    protected function formatDomain($route, &$parameters)
    {
        if ($domain = Arr::pull($parameters, '_domain')) {
            return $this->getRouteScheme($route) . $domain;
        }

        return $this->addPortToDomain(
            $this->getRouteScheme($route) . $route->getDomain()
        );
    }

    /**
     * @inheritDoc
     */
    protected function getRouteDomain($route, &$parameters)
    {
        return $route->getDomain() || Arr::has($parameters, '_domain')
            ? $this->formatDomain($route, $parameters)
            : null;
    }
}
