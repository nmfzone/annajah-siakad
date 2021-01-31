<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \Spatie\MediaLibrary\Conversions\Events\ConversionHasBeenCompleted::class => [
            \App\Listeners\MediaLibrary\SaveConversionPath::class,
        ],
        \Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAdded::class => [
            \App\Listeners\MediaLibrary\SaveFullPath::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
