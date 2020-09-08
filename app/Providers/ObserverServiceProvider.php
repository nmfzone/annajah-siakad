<?php

namespace App\Providers;

use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\User;
use App\Observers\AcademicClassObserver;
use App\Observers\AttendanceObserver;
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
        AcademicClass::observe(AcademicClassObserver::class);
        Attendance::observe(AttendanceObserver::class);
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
