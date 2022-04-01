<?php

namespace App\Console\Commands;

use App\Jobs\VerifyDomainsJob;
use App\Models\Domain;
use Illuminate\Console\Command;

class VerifyDomainsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domains:verify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a dig request to domains and verify they are pointing to our servers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        //TODO: add rate limiter and a way to re-trigger the validation via the web interaface
        $this->info('Starting to dig domains');
        $newDomains = Domain::where('verified', false)->get();
        foreach ($newDomains as $domain) {
            VerifyDomainsJob::dispatch($domain);
        }
        $this->info('All domains are in the queue');

        return 0;
    }
}
