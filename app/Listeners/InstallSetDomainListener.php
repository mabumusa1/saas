<?php

namespace App\Listeners;

use App\Events\InstallSetDomain;
use Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InstallSetDomainListener
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
     * @param InstallSetDomain $event
     * @return void
     */
    public function handle(InstallSetDomain $event)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->post(env('KUB8_API')."install/{$event->install->name}/setDomain", [
            'domain' => $event->domain->name,
        ]);
    }
}
