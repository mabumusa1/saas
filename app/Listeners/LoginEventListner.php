<?php

namespace App\Listeners;

use App\Events\ActivityLoggerEvent;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;

class LoginEventListner implements ShouldQueue
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
     * @param  \Illuminate\Auth\Events\Login  $event
     *
     * @return void
     */
    public function handle(Login $event)
    {
        ActivityLoggerEvent::dispatch([
            'performedOn' => $event->user,
            'causedBy' => $event->user,
            'log' => __('User Login'),
        ]);
    }
}
