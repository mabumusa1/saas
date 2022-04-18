<?php

namespace App\Observers;

use App\Models\Domain;

class DomainObserver
{
    /**
     * Handle the Domain "created" event.
     *
     * @param  \App\Models\Domain  $domain
     * @return void
     */
    public function created(Domain $domain)
    {
        //TODO: Send API Call to map the domain
    }

    /**
     * Handle the Domain "deleted" event.
     *
     * @param  \App\Models\Domain  $domain
     * @return void
     */
    public function deleted(Domain $domain)
    {
        //TODO: Send API Call to remove mapping
    }

    public function redirected(Domain $domain)
    {
        //TODO: Send API Call to redirect
    }

    public function makePrimary(Domain $domain)
    {
        //TODO: Send API Call to redirect
    }
}
