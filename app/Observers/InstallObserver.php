<?php

namespace App\Observers;

use App\Models\Install;
use Http;

class InstallObserver
{
    public function created($install)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->post(env('KUB8_API')."install/{$install->name}", [
            'env_type' => $install->type,
            'size' => $install->size,
            'domain' => $install->domain,
            'region' => $install->region,
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
     * Handle the Install "updated" event.
     *
     * @param  \App\Models\Install  $install
     * @return void
     */
    public function updated(Install $install)
    {
        //TODO: Send API Call to update an install
    }

    /**
     * Handle the Install "deleted" event.
     *
     * @param  \App\Models\Install  $install
     * @return void
     */
    public function deleted(Install $install)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->delete(env('KUB8_API')."install/{$install->name}");
    }

    public function copied($install)
    {
        $response = Http::withHeaders([
            'X-API-Key' => env('KUB8_API_KEY'),
        ])
        ->post(env('KUB8_API')."install/{$install->name}/copy", [
            'env_type' => $install->type,
            'size' => $install->size,
            'domain' => $install->domain,
            'region' => $install->region,
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
     * Handle the Install "locked" event.
     *
     * @param  \App\Models\Install  $install
     * @return void
     */
    public function locked(Install $install)
    {
    }
}
