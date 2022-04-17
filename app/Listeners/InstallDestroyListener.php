<?php

namespace App\Listeners;

use App\Events\InstallDestroy;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InstallDestroyListener
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
     * @param  InstallDestroy  $event
     * @return void
     */
    public function handle(InstallDestroy $event)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->delete(env('KUB8_API')."install/{$event->install->name}");
    }
}
