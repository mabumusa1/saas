<?php

namespace App\Console;

use App\Jobs\VerifyDomain;
use App\Models\Domain;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('activitylog:clean account')->quarterly();
        $schedule->command('accounts:clean')->daily();
        $unverifiedDomains = Domain::where('verified_at', null)->get();
        foreach ($unverifiedDomains as $domain) {
            $schedule->job(new VerifyDomain($domain))->everyMinute();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
