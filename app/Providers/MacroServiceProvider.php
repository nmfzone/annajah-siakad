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
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Spatie\Url\Url;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

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
        Arr::macro('implodeKeys', function (array $array, $glue = ',') {
            return implode($glue, array_keys($array));
        });

        /*
         * Deep merge array.
         * Combine (instead of replace) array with the same key (if the value is an array).
         *
         * @return array
         */
        Arr::macro('mergeDeep', function () {
            $result = [];

            foreach (func_get_args() as $array) {
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

        Collection::macro('mergeDeep', function ($items) {
            return new static(Arr::mergeDeep($this->items, $this->getArrayableItems($items)));
        });

        Str::macro('randomPlus', function ($type = 'alnum', $length = 8, $lowerOnly = false) {
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
        });

        Request::macro('removeIfNull', function ($keys) {
            $keys = is_array($keys) ? $keys : func_get_args();
            $keys = array_filter($keys, function ($key) {
                return is_null($this->get($key));
            });

            foreach ($keys as $key) {
                $this->getInputSource()->remove($key);
            }

            return $this;
        });

        Request::macro('getNextUrl', function ($default = '/') {
            $intended = $this->session->pull('url.intended');
            $next = $this->get('next');
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

        Redirector::macro('next', function (
            $default = '/',
            $status = 302,
            $headers = [],
            $secure = null
        ) {
            $path = $this->generator->getRequest()->getNextUrl($default);

            return $this->to($path, $status, $headers, $secure);
        });

        UrlGenerator::macro('mainRoute', function ($name, $parameters = [], $absolute = true) {
            $name = 'main.' . $name;

            if (! is_null($route = $this->routes->getByName($name))) {
                return $this->toRoute($route, $parameters, $absolute);
            }

            throw new RouteNotFoundException("Route [{$name}] not defined.");
        });

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

        Blade::directive('next', function () {
            return '<?php echo next_field(); ?>';
        });
    }
}
