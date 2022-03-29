<?php

namespace App\Listeners;

use App\Events\CreateInstallEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateInstallListener implements ShouldQueue
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
     * @param  \App\Events\CreateInstallEvent  $event
     *
     * @return void
     */
    public function handle(CreateInstallEvent $event)
    {
        // TODO: Send API request
    }
}
