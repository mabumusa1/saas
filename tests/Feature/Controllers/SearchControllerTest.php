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

    /**
     * @test
     */
    public function test__invoke()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $subscription = new Subscription();
        $subscription->account_id = $account->id;
        $subscription->name = 'test';
        $subscription->stripe_id = 'test';
        $subscription->stripe_status = 'test';
        $subscription->stripe_price = 'test';
        $subscription->quantity = 1;
        $subscription->trial_ends_at = null;
        $subscription->ends_at = now();
        $subscription->save();

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
            'name' => 'Site test name',
        ]);

        Install::factory()->create([
            'site_id' => $site->id,
            'name' => 'Install test name',
            'type' => 'dev',
        ]);

        $response = $this->get(
            route('site.search', $account),
            [
                'query' => 'test',
            ]
        );

        $response->assertOk();
        $response->statusText('OK');
        $response->decodeResponseJson();
    }
}
