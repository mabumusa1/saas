<?php

namespace Tests\Feature\Controllers;

use App\Events\CreateInstallEvent;
use App\Models\Account;
use App\Models\AccountUser;
use App\Models\Cashier\Subscription;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class SiteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
        $this->subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
        ]);
    }

    protected function createSite()
    {
        return Site::factory()
        ->for($this->account)
        ->for($this->subscription)
        ->create([
            'name' => 'Site test name',
        ]);
    }

    /**
     * @test
     */
    public function test_index_displays_view()
    {
        $this->createSite();

        $response = $this->call('GET', route('sites.index', $this->account), ['q'=>'test']);

        $response->assertOk();
        $response->assertViewIs('sites.index');
        $response->assertViewHas('sites');
        $response->assertViewHas('order');
    }

    public function test_index_displays_empty_with_no_sites()
    {
        $response = $this->call('GET', route('sites.index', $this->account), ['q'=>'test']);

        $response->assertOk();
        $response->assertViewIs('sites.empty');
    }

    /**
     * @test
     */
    public function test_create_displays_view()
    {
        $response = $this->get(route('sites.create', $this->account));

        $response->assertOk();
        $response->assertViewIs('sites.create');
        $response->assertViewHas('installs');
    }

    /**
     * @test
     */
    public function test_site_store()
    {
        Event::fake();
        $subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'quantity' => 10,
        ]);

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'environmentname' => 123,
            'subscription_id' => $subscription->id,
            'type' => 'stg',
        ]);

        Event::assertDispatched(CreateInstallEvent::class);

        $response->assertRedirect(route('sites.index', $this->account));
        $response->assertSessionHas('status', __('Site is under creation, we will send you an update once it is done!'));
    }

    public function test_site_store_fails_when_subscription_has_no_active_sites()
    {
        Event::fake();
        // $this->createSite();

        // dd($subscription->sites());

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'environmentname' => 123,
            'subscription_id' => $this->subscription->id,
            'type' => 'stg',
        ]);

        $response->assertRedirect(route('sites.index', $this->account));
        $response->assertSessionHas('status', __('Subscription not found, site was not created'));
    }

    public function test_show_returns_json_with_validation()
    {
        $this->createSite();

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'environmentname' => 123,
            'type' => 'stg',
            'isValidation' => true,
        ]);

        $response->assertJson(['valid' => true]);
    }

    /**
     * @test
     */
    public function test_edit_displays_view()
    {
        $site = $this->createSite();

        $response = $this->get(route('sites.edit', ['account' => $this->account, 'site' => $site]));

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
        $site = $this->createSite();

        $response = $this->put(route('sites.update', ['account' => $this->account, 'site' => $site]), [
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
        $site = $this->createSite();
        $response = $this->put(route('sites.update', ['account' => $this->account, 'site' => $site]), [
            'name' => 'test name',
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_site_destroy()
    {
        $site = $this->createSite();
        $response = $this->delete(route('sites.destroy', ['account' => $this->account, 'site' => $site]));
        $response->assertRedirect();
    }
}
