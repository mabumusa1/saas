<?php

namespace App\Jobs;

use App\Exceptions\DomainVerificationFailedException;
use App\Models\Domain;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RateLimited;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;

class VerifyDomain implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The account instance.
     *
     * @var \App\Models\Domain
     */
    public $domain;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain->withoutRelations();
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [
            new RateLimited('VerifyDomain'),
            /* @phpstan-ignore-next-line */
            (new WithoutOverlapping($this->domain->id))->dontRelease(),
            (new ThrottlesExceptions(5, 5))->backoff(5),
        ];
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addHour();
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     *
     * @return array
     */
    public function backoff()
    {
        return [60, 3600, 36000];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! VerifyDomainHelper($this->domain)) {
            $this->fail(new DomainVerificationFailedException());
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     *
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        $this->domain->verification_failed = true;
        $this->domain->save();
    }
}
