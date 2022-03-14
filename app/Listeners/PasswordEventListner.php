<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ActivityLoggerEvent;

class PasswordEventListner
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        ActivityLoggerEvent::dispatch([
            'name' =>  __('User Password Reset'),
            'performedOn' => $event->user,
            'causedBy' => $event->user,
            'withProperties' => [],
            'log' => $user->fullName . __(' Reset Password Successfully')
        ]);
    }
}
