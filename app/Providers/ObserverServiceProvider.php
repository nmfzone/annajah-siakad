<?php

namespace App\Providers;

use App\Garages\Utility\ReflectionHelper;
use App\Models\AcademicClassCourse;
use App\Models\AcademicYear;
use App\Models\Category;
use App\Models\Media;
use App\Models\Payment;
use App\Models\TransactionItem;
use App\Models\User;
use App\Observers\AcademicClassCourseObserver;
use App\Observers\AcademicYearObserver;
use App\Observers\CategoryObserver;
use App\Observers\MediaObserver;
use App\Observers\PaymentObserver;
use App\Observers\TransactionItemObserver;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
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
        Payment::observe(PaymentObserver::class);
        Category::observe(CategoryObserver::class);
        TransactionItem::observe(TransactionItemObserver::class);
        AcademicYear::observe(AcademicYearObserver::class);
        AcademicClassCourse::observe(AcademicClassCourseObserver::class);

        // Re-register model observer
        $this->reRegisterObserver(Media::class, MediaObserver::class);
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

    protected function reRegisterObserver(string $model, $observer)
    {
        $model::flushEventListeners();
        $bootedModels = ReflectionHelper::getRestrictedProperty(
            Model::class,
            'booted'
        );
        ReflectionHelper::setRestrictedProperty(
            Model::class,
            'booted',
            Arr::except($bootedModels, $model)
        );

        $model::observe($observer);
    }
}
