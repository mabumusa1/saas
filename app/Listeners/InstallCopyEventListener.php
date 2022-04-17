<?php

namespace App\Listeners;

use App\Events\InstallCopyEvent;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InstallCopyEventListener
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
     * @param InstallCopyEvent $event
     * @return void
     */
    public function handle(InstallCopyEvent $event)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->post(env('KUB8_API')."install/{$event->install->name}/copy", [
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
