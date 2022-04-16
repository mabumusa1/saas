<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Models\Install;

class Kub8WebhookJob extends ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public WebhookCall $hook;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WebhookCall $hook)
    {
        $this->hook = $hook;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $body = \json_decode($hook->payload);
            switch($body['type']){
                case "healthCheck":
                {
                    $install = Install::findOrfail($body['id']);
                    $install->status = $body['status'];
                    $install->save();
                    break;
                }
            }
        } catch (\Throwable $th) {
            $this->fail();
        }
    }
}
