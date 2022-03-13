<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
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
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        Site::factory()->create([
            'account_id' => $account->id,
            'name' => 'Site test name',
        ]);

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
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->post(route('sites.store', $account), [
            'sitename' => 'test name',
            'environmentname' => 123,
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('status'), 'Site is under creation, we will send you an update once it is done!');
    }

    /**
     * @test
     */
    public function test_edit_displays_view()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'name' => 'Site test name',
        ]);

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
    public function test_site_update_fail_without_last_name()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'name' => 'Site test name',
        ]);

        $response = $this->put(route('sites.update', ['account' => $account, 'site' => $site]), [
            'name' => '',
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('errors')->get('name')[0], 'The name field is required.');
    }

    /**
     * @test
     */
    public function test_site_update()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'name' => 'Site test name',
        ]);

        $response = $this->put(route('sites.update', ['account' => $account, 'site' => $site]), [
            'name' => 'test name',
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('status'), 'Site successfully updated!');
    }

    /**
     * @test
     */
    public function test_site_destroy()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'name' => 'test',
        ]);

        Install::factory()->create([
            'site_id' => $site->id,
            'name' => 'test',
            'type' => 'dev',
        ]);

        $response = $this->delete(route('sites.destroy', ['account' => $account, 'site' => $site]));
        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('status'), 'Site successfully deleted!');
    }
}
