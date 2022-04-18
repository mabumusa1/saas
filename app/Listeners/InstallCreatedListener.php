<?php

namespace App\Listeners;

use App\Events\InstallCreated;
use App\Models\Contact;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class InstallCreatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * The number of times the queued listener may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Handle the event.
     *
     * @param InstallCreated $event
     * @return void
     */
    public function handle(InstallCreated $event)
    {
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\InstallCreated  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(InstallCreated $event, $exception)
    {
        //
    }
}
