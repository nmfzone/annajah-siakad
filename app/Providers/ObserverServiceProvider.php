<?php

namespace App\Providers;

use App\Models\AcademicClassCourse;
use App\Models\AcademicYear;
use App\Models\TransactionItem;
use App\Models\User;
use App\Observers\AcademicClassCourseObserver;
use App\Observers\AcademicYearObserver;
use App\Observers\TransactionItemObserver;
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
        TransactionItem::observe(TransactionItemObserver::class);
        AcademicYear::observe(AcademicYearObserver::class);
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
