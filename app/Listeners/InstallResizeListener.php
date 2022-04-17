<?php

namespace App\Listeners;

use App\Events\InstallResize;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InstallResizeListener
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
     * @param InstallResize $event
     * @return void
     */
    public function handle(InstallResize $event)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->put(env('KUB8_API')."install/{$event->install->name}", [
            'env_type' => $event->install->type,
            'size' => $event->install->size,
            'domain' => $event->install->domain,
            'region' => $event->install->region,
          /*
           * This will be used i
           * the future, keep it
           */
            /*'custom' => [
                'cpu' => '1',
                'memory' => '4',
            ],*/
        ]);
    }
}
