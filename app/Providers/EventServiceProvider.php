<?php

namespace App\Providers;

use App\Events\AccountUpdatedEvent;
use App\Events\ActivityLoggerEvent;
use App\Events\InstallBackupEvent;
use App\Events\InstallCopyEvent;
use App\Events\InstallCreated;
use App\Events\InstallDestroy;
use App\Events\InstallResize;
use App\Events\InstallSetDomain;
use App\Events\SetDomainPrimaryEvent;
use App\Events\SetDomainRedirectEvent;
use App\Events\UserInvitedEvent;
use App\Listeners\InstallCopyEventListener;
use App\Listeners\InstallDestroyListener;
use App\Listeners\InstallResizeListener;
use App\Listeners\InstallSetDomainListener;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use App\Observers\DomainObserver;
use App\Observers\InstallObserver;
use App\Observers\SiteObserver;
use App\Observers\UserObserver;
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
        SetDomainRedirectEvent::class => [
            \App\Listeners\DomainRedirectListener::class,
        ],
        SetDomainPrimaryEvent::class => [
            \App\Listeners\DomainPrimaryListener::class,
        ],

        InstallCreated::class => [
            \App\Listeners\InstallCreatedListener::class,
        ],

        InstallCopyEvent::class => [
            InstallCopyEventListener::class,
        ],
        InstallResize::class => [
            InstallResizeListener::class,
        ],
        InstallDestroy::class => [
            InstallDestroyListener::class,
        ],
        InstallBackupEvent::class => [
            \App\Listeners\InstallBackupEventListener::class,
        ],
        InstallSetDomain::class => [
            InstallSetDomainListener::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        User::class => [UserObserver::class],
        Domain::class => [DomainObserver::class],
        Install::class => [InstallObserver::class],
        Site::class => [SiteObserver::class],
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
