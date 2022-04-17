<?php

namespace App\Listeners;

use App\Events\InstallStop;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InstallStopListener
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
     * @param InstallStop $event
     * @return void
     */
    public function handle(InstallStop $event)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->post(env('KUB8_API')."install/{$event->install->name}/stop");
    }
}
