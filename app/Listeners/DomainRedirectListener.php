<?php

namespace App\Listeners;

use App\Providers\SetDomainRedirectEvent;
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
     * @param  \App\Providers\SetDomainRedirectEvent  $event
     * @return void
     */
    public function handle(SetDomainRedirectEvent $event)
    {
        //
    }
}
