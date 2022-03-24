<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Cashier\Subscription;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
        $this->subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $this->site = Site::factory()
        ->for($this->account)
        ->for($this->subscription)
        ->create([
            'name' => 'Site test name',
        ]);

        Install::factory()
        ->for($this->site)
        ->create([
            'name' => 'Install test name',
            'type' => 'dev',
        ]);
    }

    /**
     * @test
     */
    public function test__invoke()
    {
        $response = $this->get(
            route('site.search', $this->account),
            [
                'query' => 'test',
            ]
        );

        $response->assertOk();
        $response->statusText('OK');
        $response->decodeResponseJson();
    }
}
