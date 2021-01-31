<?php

namespace App\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Tests\DuskTestCase;

class TestingServiceProvider extends ServiceProvider
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
        if ($this->app->runningInConsole() &&
            Str::startsWith(Arr::get($_SERVER, 'argv.1'), 'ide-helper:')) {
            DuskTestCase::registerBrowserMacro();
        }
    }
}
