<?php

namespace App\Providers;

use App\Models\AcademicClassCourse;
use App\Models\User;
use App\Observers\AcademicClassCourseObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        AcademicClassCourse::observe(AcademicClassCourseObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
