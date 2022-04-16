<?php

namespace Tests\Feature\Webhooks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Bus;
use App\Jobs\Kub8WebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;
use App\Models\Site;
use App\Models\Install;

class Kub8WebhooksTest extends TestCase
{
    use RefreshDatabase;

    private array $content = [];
    private $signKey;
    private array $headers = [];
    private Install $install;
    private Site $site;


    public function setUp(): void
    {
        parent::setUp();
        $this->setUpAccount(false);
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'prd',
        ]);
        
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
            "type" => "healthCheck",
            "id" => "1",
            "domain" => "cname.domain.com",
            "status" => "up"
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
