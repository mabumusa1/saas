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
     * @param  object  $event
     * @return void
     */
    public function handle(InstallCreated $event)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->post(env('KUB8_API')."install/{$event->install->name}", [
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
