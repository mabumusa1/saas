<?php

namespace Tests\Feature\Controllers;

use App\Events\CreateInstallEvent;
use App\Models\Account;
use App\Models\AccountUser;
use App\Models\Cashier\Subscription;
use App\Models\Install;
use App\Models\Plan;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class SiteControllerTest extends TestCase
{
    use RefreshDatabase;

    private $subscription;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
        $this->subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'name' => 's1',
        ]);
    }

    /**
     * @test
     */
    public function test_index_displays_view()
    {
        $response = $this->call('GET', route('sites.index', $this->account));

        $response->assertOk();
        $response->assertViewIs('sites.index');
        $response->assertViewHas('sites');
        $response->assertViewHas('order');
    }

    public function test_index_displays_empty_with_no_sites()
    {
        $this->account->sites()->delete();
        $response = $this->call('GET', route('sites.index', $this->account));

        $response->assertOk();
        $response->assertViewIs('sites.empty');
    }

    /**
     * @test
     */
    public function test_create_displays_view_with_subscriptions()
    {
        $response = $this->get(route('sites.create', $this->account));
        $response->assertOk();
        $response->assertViewIs('sites.create');
        $response->assertViewHas('installs');
    }

    /**
     * @test
     */
    public function test_create_displays_view_with_quota()
    {
        $this->account->quota = 5;
        $this->account->save();
        $response = $this->get(route('sites.create', $this->account));
        $response->assertOk();
        $response->assertViewIs('sites.create');
        $response->assertViewHas('installs');
    }

    /**
     * @test
     */
    public function test_site_store_blank()
    {
        $subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'quantity' => 1,
        ]);

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 'test',
            'type' => 'stg',
            'owner' => 'mine',
            'subscription_id' => $subscription->id,
            'start' => 'blank',
        ]);
        $expectedSite = $this->account->sites()->orderBy('id', 'desc')->first();
        $expectedInstall = $expectedSite->installs()->orderBy('id', 'desc')->first();
        $response->assertRedirect(route('installs.show', [$this->account, $expectedSite, $expectedInstall]));
        $response->assertSessionHas('status', __('Site is under creation, we will send you an update once it is done!'));
    }

    /**
     *  TODO: Add a test case to the exception handler.
     */
    public function test_site_store_blank_with_error()
    {
        return $this->markTestSkipped('I do not know how to test inside the exception.');

        /*
        $subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'quantity' => 1,
        ]);

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 'test',
            'type' => 'stg',
            'owner' => 'mine',
            'subscription_id' => $subscription->id,
            'start' => 'blank',
        ]);

        $response->assertRedirect(route('sites.index', [$this->account]));
        $response->assertSessionHas('status', __('An error occured, please try again in few minutes'));
        */
    }

    /**
     * @test
     */
    public function test_site_wihtout_qouta_or_subscriptions_store()
    {
        Event::fake();
        $this->subscription->delete();
        $this->account->quota = 0;
        $this->account->save();

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 123,
            'type' => 'stg',
            'owner' => 'transferable',
        ]);

        Event::assertNotDispatched(CreateInstallEvent::class);
        $response->assertForbidden();
    }

    public function test_site_store_fails_when_wrong_subscription()
    {
        Event::fake();

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 'test',
            'type' => 'stg',
            'owner' => 'mine',
            'subscription_id' => 22,
            'start' => 'blank',
        ]);

        $response->assertForbidden();
    }

    public function test_site_store_fails_when_passing_wrong_url()
    {
        $subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'quantity' => 1,
        ]);

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 'ss[]',
            'type' => 'stg',
            'owner' => 'mine',
            'subscription_id' => $subscription->id,
            'start' => 'blank',
        ]);
        $response->assertSessionHasErrors('installname');
    }

    public function test_site_store_fails_when_passing_used_subscription()
    {
        $subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'quantity' => 1,
        ]);

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 'test',
            'type' => 'stg',
            'owner' => 'mine',
            'subscription_id' => $this->subscription->id,
            'start' => 'blank',
        ]);
        $response->assertRedirect(route('sites.index', $this->account));
        $response->assertSessionHas('status', __('Subscription not found, site was not created'));
    }

    public function test_show_returns_json_with_validation()
    {
        $this->account->quota = 1;
        $this->account->save();

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 'test',
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
        $response = $this->get(route('sites.edit', ['account' => $this->account, 'site' => $this->site]));

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
        $response = $this->put(route('sites.update', ['account' => $this->account, 'site' => $this->site]), [
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
        $response = $this->put(route('sites.update', ['account' => $this->account, 'site' => $this->site]), [
            'name' => 'test name',
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_site_destroy()
    {
        $install = Install::factory()->for($this->site)->create();
        $response = $this->delete(route('sites.destroy', ['account' => $this->account, 'site' => $this->site]));
        $response->assertRedirect();
    }
}
