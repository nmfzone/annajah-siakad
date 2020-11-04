<?php

namespace App\Providers;

use App\Garages\GoogleDrive\GoogleDriveAdapter;
use App\Garages\Illuminate\Routing\UrlGenerator;
use App\Garages\Utility\IndonesianNameFormatter;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('indoNameFormatter', function () {
            return new IndonesianNameFormatter();
        });

        $this->app->instance('site', '');

        Storage::extend('google_drive', function ($app, $config) {
            $client = new Google_Client();
            $client->setAuthConfig(storage_path('app/' . $config['authConfigPath']));
            $client->addScope('https://www.googleapis.com/auth/drive.file');
            $service = new Google_Service_Drive($client);

            $options = [];
            if (isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }

            $adapter = new GoogleDriveAdapter($service, $config['folderId'], $options);

            return new Filesystem($adapter);
        });

        $this->app->singleton('url', function ($app) {
            $routes = $app['router']->getRoutes();

            $app->instance('routes', $routes);

            return new UrlGenerator(
                $routes,
                $app->rebinding(
                    'request',
                    function ($app, $request) {
                        $app['url']->setRequest($request);
                    }
                ),
                $app['config']['app.asset_url']
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
