<?php

namespace App\Listeners;

use App\Events\ActivityLoggerEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogoutEventListner
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
            'name' =>  __('User Logout'),
            'performedOn' => $event->user,
            'causedBy' => $event->user,
            'withProperties' => [],
            'log' => $event->user->fullName.__(' Logged Out Successfully'),
        ]);
    }
}
