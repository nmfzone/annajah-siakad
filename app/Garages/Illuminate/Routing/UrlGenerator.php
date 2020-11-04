<?php

namespace App\Garages\Illuminate\Routing;

use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use Illuminate\Support\Str;

class UrlGenerator extends BaseUrlGenerator
{
    /**
     * @inheritDoc
     */
    public function asset($path, $secure = null)
    {
        if ($this->isValidUrl($path)) {
            return $path;
        }

        $root = $this->assetRoot
            ? $this->assetRoot
            : $this->formatRoot($this->formatScheme($secure));

        $version = cache()->get(config('assets.version_cache_name'));

        $fullPath = $this->removeIndex($root) . '/' . trim($path, '/');

        if (! is_null($version)) {
            $fullPath .= (Str::contains($path, '?') ? '&' : '?') .
                'v=' . $version;
        }

        return $fullPath;
    }
}
