<?php

namespace App\Providers;

use App\Events\AccountUpdatedEvent;
use App\Events\ActivityLoggerEvent;
use App\Events\UserInvitedEvent;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
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
        Login::class => [
            \App\Listeners\LoginEventListner::class,
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
        UserInvitedEvent::class => [
            \App\Listeners\UserInvitedListener::class,
        ],
        AccountUpdatedEvent::class => [
            \App\Listeners\AccountUpdatedListener::class,
        ],
        ActivityLoggerEvent::class => [
            \App\Listeners\ActivityLoggerListener::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    }
}
