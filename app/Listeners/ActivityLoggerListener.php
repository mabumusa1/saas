<?php

namespace App\Listeners;

use Spatie\Activitylog\Facades\CauserResolver;

class ActivityLoggerListener
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
        CauserResolver::setCauser($event->activity['causedBy']);
        activity('account')
            ->performedOn($event->activity['performedOn'])
            ->causedBy($event->activity['causedBy'])
            ->log($event->activity['log']);
    }
}
