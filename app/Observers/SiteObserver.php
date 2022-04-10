<?php

namespace App\Observers;

use App\Models\Site;

class SiteObserver
{
    /**
     * Handle the Site "deleted" event.
     *
     * @param  \App\Models\Site  $site
     * @return void
     */
    public function deleted(Site $site)
    {
        $site->groups()->detach();
        foreach ($site->installs as $install) {
            $install->delete();
        }
    }
}
