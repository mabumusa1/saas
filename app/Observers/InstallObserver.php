<?php

namespace App\Observers;

use App\Models\Install;

class InstallObserver
{
    /**
     * Handle the Install "created" event.
     *
     * @param  \App\Models\Install  $install
     * @return void
     */
    public function created(Install $install)
    {
        //TODO: Send API Call to create an install
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
        //TODO: Send API Call to delete an install
    }
}
