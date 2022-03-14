<?php

namespace App\Listeners;

use App\Events\ActivityLoggerEvent;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AuthenticatedEventListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        ActivityLoggerEvent::dispatch([
            'name' =>  __('User Authenticated'),
            'performedOn' => $event->user,
            'causedBy' => $event->user,
            'withProperties' => [],
            /* @phpstan-ignore-next-line */
            'log' => $event->user->fullName.__(' Logged In Successfully'),
        ]);
    }
}
