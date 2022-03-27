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
            'performedOn' => $event->user,
            'causedBy' => $event->user,
            'log' => __('User Verified'),
        ]);
    }
}
