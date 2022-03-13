<?php

namespace App\Providers;

use App\Events\UserCreated;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Laravel\Cashier\Events\WebhookReceived;

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
            \App\Listeners\RegisteredEventListner::class,
        ],
        Verified::class => [
            \App\Listeners\VerifiedEventListner::class,
        ],
        Authenticated::class => [
            \App\Listeners\AuthenticatedEventListner::class,
        ],
        Logout::class => [
            \App\Listeners\LogoutEventListner::class,
        ],
        PasswordReset::class => [
            \App\Listeners\PasswordEventListner::class,
        ],
        WebhookReceived::class => [
            \App\Listeners\StripeEventListener::class,
        ],
        UserCreatedEvent::class => [
            \App\Listeners\UserCreatedListener::class,
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
