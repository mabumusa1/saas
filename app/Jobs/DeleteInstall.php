<?php

namespace App\Jobs;

use App\Models\Install;
use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class DeleteInstall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Install $install;

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
        $response = Http::kub8()->delete("install/{$this->install->name}");
        $response->onError(function ($response) {
            /* @var Response $response */
            Log::emergency(
                'Kub8 Request Failed '.$response->getStatusCode().' : '.
             \json_encode($response->body().' Orgianl Request: '.$this->install->name)
            );
        });
    }
}
