<?php

namespace App\Listeners;

use App\Events\AccountUpdatedEvent;
use App\Jobs\SyncStripe;

class AccountUpdatedListener
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
     * @param  \App\Events\AccountUpdatedEvent  $event
     *
     * @return void
     */
    public function handle(AccountUpdatedEvent $event)
    {
        SyncStripe::dispatch($event->account);
    }
}
