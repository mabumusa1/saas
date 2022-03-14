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
class SiteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_index_displays_view()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();

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

        $subscription = $subscription;
        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
            'name' => 'Site test name',
        ]);
        $account->users()->attach($user->id, ['role' => 'owner']);

        $this->actingAs($user);

        $response = $this->call('GET', route('sites.index', $account), ['q'=>'test']);

        $response->assertOk();
        $response->assertViewIs('sites.index');
        $response->assertViewHas('sites');
        $response->assertViewHas('order');
    }

    /**
     * @test
     */
    public function test_create_displays_view()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->get(route('sites.create', $account));

        $response->assertOk();
        $response->assertViewIs('sites.create');
        $response->assertViewHas('installs');
    }

    /**
     * @test
     */
    public function test_site_store()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();

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

        $subscription = $subscription;
        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
            'name' => 'Site test name',
        ]);
        $account->users()->attach($user->id, ['role' => 'owner']);

        $this->actingAs($user);

        $response = $this->post(route('sites.store', $account), [
            'sitename' => 'test name',
            'environmentname' => 123,
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_edit_displays_view()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();

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

        $subscription = $subscription;
        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
            'name' => 'Site test name',
        ]);
        $account->users()->attach($user->id, ['role' => 'owner']);

        $this->actingAs($user);

        $response = $this->get(route('sites.edit', ['account' => $account, 'site' => $site]));

        $response->assertOk();
        $response->assertViewIs('sites.edit');
        $response->assertViewHas('site');
        $response->assertViewHas('account');
        $response->assertViewHas('groups');
    }

    /**
     * @test
     */
    public function test_site_update_fail_without_name()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();

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

        $subscription = $subscription;
        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
            'name' => 'Site test name',
        ]);
        $account->users()->attach($user->id, ['role' => 'owner']);

        $this->actingAs($user);

        $response = $this->put(route('sites.update', ['account' => $account, 'site' => $site]), [
            'name' => '',
        ]);

        $response->assertRedirect();
        $this->assertEquals(session('errors')->get('name')[0], 'The name field is required.');
    }

    /**
     * @test
     */
    public function test_site_update()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();

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

        $subscription = $subscription;
        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
            'name' => 'Site test name',
        ]);
        $account->users()->attach($user->id, ['role' => 'owner']);

        $this->actingAs($user);

        $response = $this->put(route('sites.update', ['account' => $account, 'site' => $site]), [
            'name' => 'test name',
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_site_destroy()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();

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

        $subscription = $subscription;
        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
            'name' => 'Site test name',
        ]);
        $account->users()->attach($user->id, ['role' => 'owner']);

        $this->actingAs($user);

        $response = $this->delete(route('sites.destroy', ['account' => $account, 'site' => $site]));
        $response->assertRedirect();
    }
}
