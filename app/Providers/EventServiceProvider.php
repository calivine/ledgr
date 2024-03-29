<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        'App\Events\TransactionWasCreated' => [
            'App\Listeners\UpdateBudget',
        ],
        'App\Events\IconWasChanged' => [
            'App\Listeners\UpdateIcon',
        ],
        'App\Events\PlannedBudgetChanged' => [
            'App\Listeners\UpdatePlanned',
        ],
        'App\Events\TransactionCategoryChanged' => [
            'App\Listeners\UpdateActual',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
