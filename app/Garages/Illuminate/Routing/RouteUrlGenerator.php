<?php

namespace App\Garages\Illuminate\Routing;

use Illuminate\Routing\RouteUrlGenerator as BaseUrlGenerator;
use Illuminate\Support\Arr;

class RouteUrlGenerator extends BaseUrlGenerator
{
    /**
     * @inheritDoc
     */
    protected function formatDomain($route, &$parameters): string
    {
        $domain = $route->getDomain();

        if (Arr::has($parameters, '_domain')) {
            $domain = Arr::pull($parameters, '_domain');
        }

        $domain = $this->getRouteScheme($route) . $domain;

        return Arr::get($route->action, 'wildcard_port', true)
            ? $this->addPortToDomain($domain)
            : $domain;
    }

    /**
     * @inheritDoc
     */
    protected function getRouteDomain($route, &$parameters): ?string
    {
        return $route->getDomain() || Arr::has($parameters, '_domain')
            ? $this->formatDomain($route, $parameters)
            : null;
    }

    /**
     * @inheritDoc
     */
    protected function replaceRouteParameters($path, array &$parameters): string
    {
        $path = $this->replaceSubDomainParameter($path, $parameters);

        return parent::replaceRouteParameters($path, $parameters);
    }

    protected function replaceSubDomainParameter($path, &$parameters)
    {
        return preg_replace_callback('/\{(sub_domain)(\?)?\}/', function ($m) use (&$parameters) {
            if (isset($parameters[$m[1]])) { // allows empty sub_domain
                return trim(Arr::pull($parameters, $m[1]));
            } elseif (isset($this->defaultParameters[$m[1]])) {
                return $this->defaultParameters[$m[1]];
            }

            return $m[0];
        }, $path);
    }
}
