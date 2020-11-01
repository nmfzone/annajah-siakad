<?php

namespace App\Garages\Utility;

use App\Enums\SiteSetting;
use App\Models\Site as SiteModel;
use Illuminate\Support\Str;

class Site
{
    public static function title()
    {
        return object_get(static::site(), 'title', config('app.name', 'Laravel'));
    }

    public static function email()
    {
        $value = self::site()->email;

        return empty($value) ? '-' : $value;
    }

    public static function address()
    {
        $value = self::site()->address;

        return empty($value) ? '-' : $value;
    }

    public static function phone()
    {
        $value = self::site()->phone;

        return empty($value) ? '-' : $value;
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

    public static function menus()
    {
        if (is_main_app()) {
            $menus = [];
        } else {
            $menus = self::site()->settings()->get(SiteSetting::MENUS);

            $menus = [
                [
                    'id' => 1,
                    'url' => switch_route('auto', 'web'),
                    'title' => 'Home',
                ],
                [
                    'id' => 2,
                    'url' => '#',
                    'title' => 'Profil',
                    'children' => [
                        [
                            'id' => 6,
                            'url' => '#',
                            'title' => 'Visi & Misi',
                        ],
                        ['id' => 7, 'url' => '#', 'title' => 'Sejarah'],
                    ]
                ],
                [
                    'id' => 3,
                    'url' => '#',
                    'title' => 'Kurikulum',
                ],
                [
                    'id' => 4,
                    'url' => '#',
                    'title' => 'Kesiswaan',
                ],
                [
                    'id' => 5,
                    'url' => sub_route('ppdb.index'),
                    'highlight' => true,
                    'title' => 'PPDB',
                ],
            ];
        }

        if (auth()->guest()) {
            $menus = array_merge($menus, [
                [
                    'id' => 900,
                    'url' => main_route('login', ['next' => sub_route('dashboard')]),
                    'title' => 'Login'
                ]
            ]);
        } else {
            $menus = array_merge($menus, [
                [
                    'id' => 901,
                    'url' => sub_route('dashboard'),
                    'title' => 'Dashboard'
                ]
            ]);
        }

        return $menus;
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
