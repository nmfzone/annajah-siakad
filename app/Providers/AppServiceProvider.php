<?php

namespace App\Providers;

use App\Garages\GoogleDrive\GoogleDriveAdapter;
use App\Garages\Illuminate\Routing\Matching\HostValidator;
use App\Garages\Illuminate\Routing\Router;
use App\Garages\Illuminate\Routing\UrlGenerator;
use App\Garages\Utility\IndonesianNameFormatter;
use App\Models\PpdbUser;
use App\Models\Student;
use App\Models\Teacher;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Matching\MethodValidator;
use Illuminate\Routing\Matching\SchemeValidator;
use Illuminate\Routing\Matching\UriValidator;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use League\Flysystem\Filesystem;
use Spatie\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator;

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
            $client->addScope('https://www.googleapis.com/auth/drive');
            $service = new Google_Service_Drive($client);

            $options = [];
            if (isset($config['teamDriveId'])) {
                $options['teamDriveId'] = $config['teamDriveId'];
            }

            $adapter = new GoogleDriveAdapter($service, $config['folderId'], $options);

            return new Filesystem($adapter);
        });

        $this->app->bind(
            \Spatie\MediaLibrary\MediaCollections\Filesystem::class,
            \App\Garages\MediaLibrary\Filesystem::class
        );

        $this->app->bind(
            \Spatie\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator::class,
            \App\Garages\MediaLibrary\ResponsiveImages\ResponsiveImageGenerator::class
        );

        $this->overrideRouter();

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

        Route::$validators = [
            new UriValidator,
            new MethodValidator,
            new SchemeValidator,
            new HostValidator
        ];
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

    protected function overrideRouter()
    {
        $this->app->booted(function () {
            $newRouter = new Router($this->app['events'], $this->app);
            $newRouter->setRoutes($this->app['router']->getRoutes());
            $newRouter->setMiddleware($this->app['router']->getMiddleware());
            $newRouter->setMiddlewareGroups($this->app['router']->getMiddlewareGroups());
            $newRouter->middlewarePriority = $this->app['router']->middlewarePriority;

            $this->app['router'] = $newRouter;

            $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);
            $kernel->setRouter($newRouter);
        });
    }
}
