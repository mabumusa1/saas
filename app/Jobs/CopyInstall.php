<?php

namespace App\Jobs;

use App\Models\Install;
use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CopyInstall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Install $install;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Install $install)
    {
        $this->install = $install;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::kub8()->post('install/copy', [
            'id'=> $this->install->name,
            'env_type' => $this->install->type,
            'size' => $this->install->size,
            'domain' => $this->install->domain,
            'region' => $this->install->region,
        ]);
    }
}
