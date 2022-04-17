<?php

namespace App\Listeners;

use App\Events\InstallBackupEvent;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InstallBackupEventListener
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
     * @param InstallBackupEvent $event
     * @return void
     */
    public function handle(InstallBackupEvent $event)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->post(env('KUB8_API')."install/{$event->install->name}/backup/{$event->source}");
    }
}
