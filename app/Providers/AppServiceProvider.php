<?php

namespace App\Providers;

use App\Garages\GoogleDrive\GoogleDriveAdapter;
use App\Garages\Illuminate\Routing\UrlGenerator;
use App\Garages\Utility\IndonesianNameFormatter;
use App\Models\PpdbUser;
use App\Models\Student;
use App\Models\Teacher;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
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

        Sanctum::$runsMigrations = false;

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

        $this->app->extend(\Spatie\MediaLibrary\MediaCollections\Filesystem::class, function () {
            return $this->app->make(\App\Garages\MediaLibrary\Filesystem::class);
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

        Relation::morphMap([
            'ppdb_user' => PpdbUser::class,
            'teacher' => Teacher::class,
            'student' => Student::class,
        ]);
    }
}
