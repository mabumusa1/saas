<?php

namespace App\Observers;

use App\Jobs\CopyInstall;
use App\Jobs\CreateInstall;
use App\Jobs\DeleteInstall;
use App\Models\Install;
use Http;

class InstallObserver
{
    public function created($install)
    {
        CreateInstall::dispatch($install);
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
        DeleteInstall::dispatch($install);
    }

    public function copied($install)
    {
        CopyInstall::dispatch($install);
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
