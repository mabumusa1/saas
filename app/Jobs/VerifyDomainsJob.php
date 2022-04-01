<?php

namespace App\Jobs;

use App\Models\Domain;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\Dns\Dns;

class VerifyDomainsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addMinutes(10);
    }

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 5;

    /**
     * The account instance.
     *
     * @var \App\Models\Domain
     */
    protected $domain;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dns = new Dns();
        $records = $dns->useNameserver('8.8.8.8')->getRecords($this->domain->name, 'CNAME');

        if ($records) {
            foreach ($records as $record) {
                if ($record->target() === $this->domain->install->cname) {
                    $this->domain->verified = true;
                    $this->domain->verified_at = now();
                    $this->domain->save();
                } else {
                    $this->failedDomainVerification();
                }
            }
        } else {
            $this->failedDomainVerification();
        }
    }

    private function failedDomainVerification()
    {
        $this->domain->verification_attempts = $this->domain->verification_attempts + 1;
        $this->domain->save();
        $this->fail();
    }
}
