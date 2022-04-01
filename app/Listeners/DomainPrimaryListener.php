<?php

namespace App\Listeners;

use App\Events\SetDomainPrimaryEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DomainPrimaryListener
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
     * @param  \App\Events\SetDomainPrimaryEvent  $event
     * @return void
     */
    public function handle(SetDomainPrimaryEvent $event)
    {
        //
    }
}
