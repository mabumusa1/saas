<?php

namespace Tests\Feature\Jobs;

use App\Jobs\Kub8WebhookJob;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\WebhookClient\Models\WebhookCall;
use Tests\TestCase;

class Kub8WebhookJobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
    }

    public function test_healthCheck()
    {
        $hook = WebhookCall::create([
            'name' => 'configname',
            'url' => 'url',
            'headers' => [],
            'payload' => \json_encode([
                'type' => 'healthCheck',
                'id' => $this->install->id,
                'domain' => 'cname.domain.com',
                'status' => 'up',
            ]),
        ]);

        Kub8WebhookJob::dispatch($hook);

        $after = $this->install->refresh();

        $this->assertEquals($this->install->status, 'up');
    }
}
