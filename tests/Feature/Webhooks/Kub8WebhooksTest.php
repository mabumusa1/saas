<?php

namespace Tests\Feature\Webhooks;

use App\Jobs\Kub8WebhookJob;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Spatie\WebhookClient\Models\WebhookCall;
use Tests\TestCase;

class Kub8WebhooksTest extends TestCase
{
    use RefreshDatabase;

    private array $content = [];

    private $signKey;

    private array $headers = [];

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite(true);
    }

    private function updateReqest()
    {
        $this->signKey = env('KUB8_WEBHOOK_CLIENT_SECRET');
        $this->headers['x-signature'] = hash_hmac('sha256', json_encode($this->content), $this->signKey);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_basic_hook()
    {
        Bus::fake();
        $this->content = [
            'type' => 'healthCheck',
            'id' => '1',
            'domain' => 'cname.domain.com',
            'status' => 'up',
        ];

        $this->updateReqest();

        $response = $this->withHeaders($this->headers)
        ->postJson('kub8', $this->content);

        $response->assertStatus(200);
        $this->assertDatabaseCount('webhook_calls', 1);

        $hook = WebhookCall::find(1);

        Bus::assertDispatched(function (Kub8WebhookJob $job) use ($hook) {
            return $job->hook->id === $hook->id;
        });
    }
}
