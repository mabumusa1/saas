<?php

namespace App\Observers;

use App\Models\Install;
use Http;

class InstallObserver
{
    public function created($install)
    {
        $response = Http::kub8()->post("install/{$install->name}", [
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
        $response = Http::kub8()->delete("install/{$install->name}");
    }

    public function copied($install)
    {
        $response = Http::kub8()->post("install/{$install->name}/copy", [
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
