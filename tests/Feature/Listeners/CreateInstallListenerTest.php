<?php

namespace Tests\Feature\Listeners;

use App\Events\InstallCreated;
use App\Listeners\InstallCreatedListener;
use App\Models\Account;
use App\Models\Cashier\Subscription;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CreateInstallListenerTest extends TestCase
{
    use RefreshDatabase;

    private $subscription;

    public function setUp(): void
    {
        parent::setUp();
        $this->setUpAccount(true);
        $this->subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'name' => 's5',
        ]);

        $this->site = Site::factory()
        ->for($this->account)
        ->for($this->subscription)
        ->create();

        $this->install = Install::factory()
        ->for($this->site)
        ->create([
            'type' => 'prd',
        ]);
    }

    public function test_install_create_handle()
    {
        Http::fake();

        $event = new InstallCreated($this->install);

        $listener = new InstallCreatedListener();

        $listener->handle($event);
        Http::assertSent(function (Request $request) {
            return $request->hasHeader('X-API-Key', env('KUB8_API_KEY')) &&
            $request->url() == env('KUB8_API')."install/{$this->install->name}" &&
            $request['env_type'] == $this->install->type &&
            $request['size'] == $this->install->size &&
            $request['domain'] == $this->install->domain;
            $request['region'] == $this->install->region;
        });
    }
}
