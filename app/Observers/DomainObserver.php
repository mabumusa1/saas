<?php

namespace App\Observers;

use App\Models\Domain;

class DomainObserver
{
    /**
     * Handle events after all transactions are committed.
     *
     * @var bool
     */
    public $afterCommit = true;

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
     * Handle the Domain "updated" event.
     *
     * @param  \App\Models\Domain  $domain
     * @return void
     */
    public function updated(Domain $domain)
    {
        //
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
}
