<?php

namespace App\Console\Commands;

use App\Models\Site;
use App\Models\Subscription;
use Illuminate\Console\Command;

class DeleteUnsubscribedSites extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sites:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete sites that are unsubscribed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $cancelledSites = Subscription::whereNotNull('ends_at')->get();

        $cancelledSites->each(function ($subscription) {
            $site = Site::find($subscription->site_id);
            $site->delete();
        });

        return 0;
    }
}
