<?php

namespace App\Console\Commands;

use App\Models\Account;
use App\Models\User;
use Illuminate\Console\Command;

class CleanUnusedAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove unverified emails for the last 30 days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Deleting old unverified users...');
        $toDelete = User::whereNull('email_verified_at')
            ->where('created_at', '<', now()->subDays(30))
            ->get();

            foreach ($toDelete as $user) {
            $user->accounts()->detach();
            $user->delete();
        }
        $this->comment("Deleted {$toDelete} unverified users.");
        $this->info('All done!');
        return 0;
    }
}
