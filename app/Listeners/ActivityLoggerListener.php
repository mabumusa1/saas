<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ActivityLoggerListener
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
        activity($event->activity['name'])
            ->performedOn($event->activity['user'])
            ->causedBy($event->activity['causedBy'])
            ->withProperties($event->activity['withProperties'])
            ->log($event->activity['log']);        
    }
}
