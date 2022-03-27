<?php

namespace App\Listeners;

use App\Events\ActivityLoggerEvent;

class VerifiedEventListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     *
     * @return void
     */
    public function handle($event)
    {
        ActivityLoggerEvent::dispatch([
            'name' => __('User Email Verified'),
            'performedOn' => $event->user,
            'causedBy' => $event->user,
            'withProperties' => [],
            'log' => $event->user->fullName.__(' Verified'),
        ]);
    }
}
