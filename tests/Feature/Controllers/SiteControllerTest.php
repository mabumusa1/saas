<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\Install;
use App\Models\Plan;
use App\Models\Site;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
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
        $response = $this->get(route('sites.index', $this->account));

        $response->assertOk();
        $response->assertViewIs('sites.index');
        $response->assertViewHas('sites');
        $response->assertViewHas('order');
    }

    public function test_index_displays_view_with_query()
    {
        $response = $this->call('GET', route('sites.index', $this->account), ['q' => $this->site->name]);

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
        //There's no case that will give the site create view installs variable
        // $response->assertViewHas('installs');
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
        //There's no case that will give the site create view installs variable
        // $response->assertViewHas('installs');
    }

    /**
     * @test
     */
    public function test_site_store_blank()
    {
        Event::fake();
        $subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'quantity' => 1,
        ]);
        $plan = Plan::factory()->create();

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 'test',
            'type' => 'dev',
            'owner' => 'mine',
            'subscription_id' => $subscription->id,
            'start' => 'blank',
            'planId' => $plan->id,
            'period' => 'month',
        ]);
        Event::assertDispatched('eloquent.created: App\Models\Site');
        Event::assertDispatched('eloquent.created: App\Models\Install');
        $expectedSite = $this->account->sites()->orderBy('id', 'desc')->first();
        $expectedInstall = $expectedSite->installs()->orderBy('id', 'desc')->first();
        $response->assertRedirect(route('installs.show', [$this->account, $expectedSite, $expectedInstall]));
        $response->assertSessionHas('status', __('Site is under creation, we will send you an update once it is done!'));
    }

    /**
     * @test
     */
    public function test_site_wihtout_qouta_or_subscriptions_store_with_dev_type()
    {
        $this->subscription->delete();
        $this->account->quota = 0;
        $this->account->save();

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 123,
            'type' => 'dev',
            'owner' => 'transferable',
            'start' => 'blank',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['type']);
    }

    public function test_site_wihtout_qouta_or_subscriptions_store_with_prod_type()
    {
        $this->subscription->delete();
        $this->account->quota = 0;
        $this->account->save();
        $plan = Plan::factory()->create();

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 123,
            'type' => 'prd',
            'owner' => 'mine',
            'start' => 'blank',
            'planId' => $plan->id,
            'period' => 'month',
        ]);
        $response->assertForbidden();
    }

    //Site Store does not take subscription id from the request
    // public function test_site_store_fails_when_wrong_subscription()
    // {
    //     $response = $this->post(route('sites.store', $this->account), [
    //         'sitename' => 'test name',
    //         'installname' => 'test',
    //         'type' => 'dev',
    //         'owner' => 'mine',
    //         'subscription_id' => 22,
    //         'start' => 'blank',
    //     ]);
    //     $response->assertSessionHasErrors('subscription_id');
    // }

    public function test_site_store_fails_when_passing_wrong_url()
    {
        $subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'quantity' => 1,
        ]);

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 'ss[]',
            'type' => 'dev',
            'owner' => 'mine',
            'subscription_id' => $subscription->id,
            'start' => 'blank',
        ]);
        $response->assertSessionHasErrors('installname');
    }

    //Site does not take subscription id from the request
    // public function test_site_store_fails_when_passing_used_subscription()
    // {
    //     $subscription = Subscription::factory()->create([
    //         'account_id' => $this->account->id,
    //         'quantity' => 1,
    //     ]);

    //     $response = $this->post(route('sites.store', $this->account), [
    //         'sitename' => 'test name',
    //         'installname' => 'test',
    //         'type' => 'dev',
    //         'owner' => 'mine',
    //         'subscription_id' => $this->subscription->id,
    //         'start' => 'blank',
    //     ]);
    //     $response->assertRedirect(route('sites.index', $this->account));
    //     $response->assertSessionHas('status', __('Subscription not found, site was not created'));
    // }

    public function test_show_returns_json_with_validation()
    {
        $this->account->quota = 1;
        $this->account->save();

        $response = $this->post(route('sites.store', $this->account), [
            'sitename' => 'test name',
            'installname' => 'test',
            'type' => 'dev',
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
    public function test_site_destroy_with_ended_subscription()
    {
        $subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'quantity' => 1,
            'ends_at' => Carbon::now()->subDays(15),
        ]);
        $site = Site::factory()->for($this->subscription)->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()->for($this->site)->create();
        $response = $this->delete(route('sites.destroy', ['account' => $this->account, 'site' => $site]));
        $this->assertModelMissing($this->site);
        $this->assertModelMissing($install);
        $response->assertRedirect();
    }

    public function test_site_destroy_with_ongoing_subscription()
    {
        Queue::fake();
        $subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'quantity' => 1,
            'ends_at' => Carbon::now()->addDays(15),
        ]);
        $site = Site::factory()->for($this->subscription)->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()->for($site)->create();
        $response = $this->delete(route('sites.destroy', ['account' => $this->account, 'site' => $site]));
        Queue::assertPushed(DeleteSite::class, function ($job) {
            dd($job);

            return ! is_null($job);
        });
    }
}
