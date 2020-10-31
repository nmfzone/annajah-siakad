<?php

namespace App\Garages\Utility;

use App\Models\Site as SiteModel;
use Illuminate\Support\Str;

class Site
{
    public static function title()
    {
        return object_get(static::site(), 'title', config('app.name', 'Laravel'));
    }

    public static function instagram()
    {
        $value = self::site()->instagram;

        return empty($value) ? '-' : 'https://instagram.com/' . $value;
    }

    public static function facebook()
    {
        $value = self::site()->facebook;

        return empty($value) ? '-' : 'https://facebook.com/' . $value;
    }

    public static function twitter()
    {
        $value = self::site()->twitter;

        return empty($value) ? '-' : 'https://twitter.com/' . $value;
    }

    public static function logo()
    {
        return is_main_app()
            ? asset('images/logo.png')
            : static::site()->logo;
    }

    protected static function site(): ?SiteModel
    {
        $site = app()->make('site');

        return empty($site) ? null : $site;
    }

    public static function __callStatic($method, $parameters)
    {
        if (Str::startsWith(Str::snake($method), 'has_')) {
            $value = call_user_func([
                __CLASS__,
                Str::after($method, 'has')
            ]);

            return ! empty($value) && $value != '-';
        }
    }
}
