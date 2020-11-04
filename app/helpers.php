<?php

use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

if (! function_exists('join_paths')) {
    /**
     * Handle the path joins.
     *
     * @param  array<int, mixed>  $args
     * @return string
     *
     * @throws \Exception
     */
    function join_paths(...$args)
    {
        if (count($args) < 2) {
            throw new \Exception('join_paths() require atleast 2 arguments!');
        }

        $paths = [];

        foreach ($args as $arg) {
            $paths = array_merge($paths, (array) $arg);
        }

        foreach ($paths as &$path) {
            $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        }

        $firstPath = rtrim($paths[0], DIRECTORY_SEPARATOR);

        $paths = array_map(function ($p) {
            return trim($p, sprintf('"%s"', DIRECTORY_SEPARATOR));
        }, array_slice($paths, 1));

        $paths = array_merge([$firstPath], $paths);

        return join(DIRECTORY_SEPARATOR, $paths);
    }
}

if (! function_exists('join_url')) {
    /**
     * Handle the url joins.
     *
     * @param  array<int, mixed>  $args
     * @return string
     *
     * @throws \Exception
     */
    function join_url(...$args)
    {
        if (count($args) < 2) {
            throw new \Exception('join_url() require atleast 2 arguments!');
        }

        $paths = [];

        foreach ($args as $arg) {
            $paths = array_merge($paths, (array) $arg);
        }

        $paths = array_map(function ($p) {
            return trim($p, sprintf('"%s"', '/'));
        }, $paths);

        return join('/', $paths);
    }
}

if (! function_exists('main_route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function main_route($name, $parameters = [], $absolute = true)
    {
        return app('url')->mainRoute($name, $parameters, $absolute);
    }
}

if (! function_exists('sub_route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function sub_route($name, $parameters = [], $absolute = true)
    {
        return app('url')->subRoute($name, $parameters, $absolute);
    }
}

if (! function_exists('switch_route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param  string|null  $type
     * @param  array|string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function switch_route($type, $name, $parameters = [], $absolute = true)
    {
        if ($type == 'auto') {
            $type = is_main_app() ? 'main' : 'sub';
        }

        if ($type == 'main') {
            return main_route($name, $parameters, $absolute);
        } elseif ($type == 'sub') {
            return sub_route($name, $parameters, $absolute);
        }

        return route($name, $parameters, $absolute);
    }
}

if (! function_exists('is_main_app')) {
    /**
     * Determine whether current url is main app.
     *
     * @return bool
     */
    function is_main_app()
    {
        return app('request')->getHttpHost() == config('app.host');
    }
}

if (! function_exists('next_field')) {
    /**
     * Generate a next url form field.
     *
     * @return \Illuminate\Support\HtmlString
     */
    function next_field()
    {
        return new HtmlString('<input type="hidden" name="next" value="' . request()->getNextUrl() . '">');
    }
}

if (! function_exists('create_dir')) {
    /**
     * Create the directory if not exists yet.
     *
     * @param  string  $path
     * @param  int  $permission
     * @return string
     */
    function create_dir($path, $permission = 0775)
    {
        if (! File::exists($path)) {
            File::makeDirectory($path, $permission, true, true);
        }

        return $path;
    }
}

if (! function_exists('tmp_path')) {
    /**
     * Get the temporary path used by system.
     *
     * @param  string  $path
     * @return string
     *
     * @throws \Exception
     */
    function tmp_path($path = '')
    {
        return join_paths(sys_get_temp_dir(), $path);
    }
}
