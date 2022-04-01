<?php

namespace App\Listeners;

use App\Events\SetDomainRedirectEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DomainRedirectListener
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
     * @param  \App\Events\SetDomainRedirectEvent  $event
     * @return void
     */
    public function handle(SetDomainRedirectEvent $event)
    {
        //
    }
}
