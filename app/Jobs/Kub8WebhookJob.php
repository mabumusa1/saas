<?php

namespace App\Jobs;

use App\Models\Install;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

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
        /* @phpstan-ignore-next-line */
        $body = \json_decode($this->hook->payload, true);
        switch ($body['type']) {
            case 'healthCheck':
            {
                $install = Install::findOrfail($body['id']);
                $install->status = $body['status'];
                $install->save();
                break;
                }
        }
    }
}
