<?php

namespace App\Garages\Illuminate\Routing\Matching;

use Illuminate\Http\Request;
use Illuminate\Routing\Matching\HostValidator as BaseValidator;
use Illuminate\Routing\Route;

class HostValidator extends BaseValidator
{
    /**
     * @inheritDoc
     */
    public function matches(Route $route, Request $request)
    {
        $hostRegex = $route->getCompiled()->getHostRegex();

        if (is_null($hostRegex)) {
            return true;
        }

        return preg_match($hostRegex, $request->getHttpHost());
    }
}
