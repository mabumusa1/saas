<?php

namespace App\Listeners;

use App\Events\AccountUpdatedEvent;
use App\Jobs\SyncStripe;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountUpdatedListener implements ShouldQueue
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
