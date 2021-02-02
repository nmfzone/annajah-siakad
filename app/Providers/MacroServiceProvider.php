<?php

namespace App\Providers;

use DomainException;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Spatie\Url\Url;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Yajra\DataTables\Html\Builder as DataTableBuilder;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Implode array keys.
         *
         * @param  array  $array
         * @param  string  $glue
         * @return string
         */
        Arr::macro('implodeKeys', function (array $array, string $glue = ',') {
            return implode($glue, array_keys($array));
        });

        /**
         * Deep merge array.
         * Combine (instead of replace) array with the same key (if the value is an array).
         *
         * @param  mixed  $args,...
         * @return array
         */
        Arr::macro('mergeDeep', function (...$args) {
            $result = [];

            foreach ($args as $array) {
                foreach (Arr::wrap($array) as $key => $value) {
                    if (is_integer($key)) {
                        $result[] = $value;
                    } elseif (isset($result[$key]) && is_array($result[$key]) && is_array($value)) {
                        $result[$key] = Arr::mergeDeep($result[$key], $value);
                    } else {
                        $result[$key] = $value;
                    }
                }
            }

            return $result;
        });

        /**
         * Deep merge array to the collection.
         *
         * @param  mixed  $items
         * @return \Illuminate\Support\Collection
         */
        Collection::macro('mergeDeep', function ($items) {
            return new static(Arr::mergeDeep($this->items, $this->getArrayableItems($items)));
        });

        /**
         * Generate a random string.
         *
         * @param  string  $type
         * @param  int  $length
         * @param  bool  $lowerOnly
         * @return string
         */
        Str::macro(
            'randomPlus',
            function (string $type = 'alnum', int $length = 8, bool $lowerOnly = false) {
                if ($type == 'alnum') {
                    $pool = '0123456789abcdefghijklmnopqrstuvwxyz';

                    if (! $lowerOnly) {
                        $pool .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    }
                } elseif ($type == 'alpha') {
                    $pool = 'abcdefghijklmnopqrstuvwxyz';

                    if (! $lowerOnly) {
                        $pool .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    }
                } elseif ($type == 'numeric') {
                    $pool = '0123456789';
                } elseif ($type == 'nozero') {
                    $pool = '123456789';
                } else {
                    throw new Exception("Type '{$type}' is not supported.");
                }

                return substr(str_shuffle(
                    str_repeat($pool, (int) ceil($length / strlen($pool)))
                ), 0, $length);
            }
        );

        /**
         * Clean the given string.
         *
         * @param  string  $text
         * @return string
         */
        Str::macro('cleanString', function (string $text) {
            $text = preg_replace("/[\r\n]+/", ' ', $text);
            $text = preg_replace("/[ ]+/", ' ', $text);

            return $text;
        });

        /**
         * Remove the keys if they're null.
         *
         * @param  mixed  $keys,...
         * @return \Illuminate\Http\Request
         */
        Request::macro('removeIfNull', function (...$keys) {
            $keys = array_filter($keys, function ($key) {
                return is_null($this->input($key));
            });

            foreach ($keys as $key) {
                $this->getInputSource()->remove($key);
            }

            return $this;
        });

        /**
         * Get next url from request.
         *
         * @param  string  $default
         * @return string
         */
        Request::macro('getNextUrl', function ($default = '/') {
            $intended = $this->session->pull('url.intended');
            $next = $this->input('next');
            $path = null;

            if ($intended) {
                $path = $intended;
            } elseif ($next && parse_url($next)) {
                $url = Url::fromString($next);

                if (empty($url->getHost())) {
                    $url = $url->withScheme($this->getScheme());
                    $url = $url->withHost($this->getHttpHost());
                }

                if ($url->getHost() == config('app.host') ||
                    Str::endsWith($url->getHost(), '.' . config('app.host')) ||
                    app()->isLocal()) {
                    $path = (string) $url;
                }
            }

            return $path ? $path : $default;
        });

        /**
         * Redirect to the next url.
         *
         * @param  string  $default
         * @param  int  $status
         * @param  array  $headers
         * @param  bool|null  $secure
         * @return \Illuminate\Http\RedirectResponse
         */
        Redirector::macro('next', function (
            $default = '/',
            $status = 302,
            $headers = [],
            $secure = null
        ) {
            $path = $this->generator->getRequest()->getNextUrl($default);

            return $this->to($path, $status, $headers, $secure);
        });

        /**
         * Get the URL to the main site for a given route instance.
         *
         * @param  \Illuminate\Routing\Route  $route
         * @param  mixed  $parameters
         * @param  bool  $absolute
         * @return string
         *
         * @throws \Illuminate\Routing\Exceptions\UrlGenerationException
         */
        UrlGenerator::macro('mainRoute', function ($name, $parameters = [], $absolute = true) {
            $name = 'main.' . $name;

            if (! is_null($route = $this->routes->getByName($name))) {
                return $this->toRoute($route, $parameters, $absolute);
            }

            throw new RouteNotFoundException("Route [{$name}] not defined.");
        });

        /**
         * Get the URL to the sub site for a given route instance.
         *
         * @param  \Illuminate\Routing\Route  $route
         * @param  mixed  $parameters
         * @param  bool  $absolute
         * @return string
         *
         * @throws \Illuminate\Routing\Exceptions\UrlGenerationException
         */
        UrlGenerator::macro('subRoute', function ($name, $parameters = [], $absolute = true) {
            $name = 'sub.' . $name;

            if (is_main_app()) {
                throw new DomainException(
                    'Sub Route can only be used in Subdomain, not in main domain.'
                );
            }

            $subDomain = Str::lower(
                str_replace(
                    '.' . config('app.host'),
                    '',
                    request()->getHttpHost()
                )
            );

            $parameters = array_merge([
                'sub_domain' => $subDomain,
            ], Arr::wrap($parameters));

            if (! is_null($route = $this->routes->getByName($name))) {
                return $this->toRoute($route, $parameters, $absolute);
            }

            throw new RouteNotFoundException("Route [{$name}] not defined.");
        });

        /**
         * Display next field.
         *
         * @return string
         */
        Blade::directive('next', function () {
            return '<?php echo next_field(); ?>';
        });

        /**
         * Get DataTable attributes.
         *
         * @return array
         */
        DataTableBuilder::macro('getAttributes', function () {
            return $this->attributes;
        });
    }
}
