<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Cashier\Subscription;
use App\Models\Group;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GroupController
 */
class GroupControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $account;

    /**
     * @property \Illuminate\Contracts\Auth\Authenticatable $user
     */
    protected $user;

    /**
     * @property \App\Models\Subscription $subscription
     */
    protected $subscription;

    public function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->create();
        $this->user = User::factory()->create();
        $this->account->users()->attach($this->user->id, ['role' => 'owner']);

        $this->actingAs($this->user);

        $this->subscription = new Subscription();
        $this->subscription->account_id = $this->account->id;
        $this->subscription->name = 'test';
        $this->subscription->stripe_id = 'test';
        $this->subscription->stripe_status = 'test';
        $this->subscription->stripe_price = 'test';
        $this->subscription->quantity = 1;
        $this->subscription->trial_ends_at = null;
        $this->subscription->ends_at = now();
        $this->subscription->save();
    }

    /**
     * @test
     */
    public function index_displays_view()
    {
        Group::factory()->create([
            'name' => 'test',
            'notes' => 'test',
            'account_id' => $this->account->id,
        ]);

        Site::factory()->create([
            'account_id' => $this->account->id,
            'subscription_id' => $this->subscription->id,
            'name' => 'test',
        ]);

        $response = $this->call('GET', route('groups.index', $this->account), ['q'=>'test']);
        $response->assertOk();
        $response->assertViewIs('groups.index');
        $response->assertViewHas('account');
    }

    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('groups.create', $this->account));
        $response->assertOk();
        $response->assertViewIs('groups.create');
        $response->assertViewHas('account');
    }

    /**
     * @test
     */
    public function test_successful_store()
    {
        $data = [
            'name'=>'admin',
            'notes'=>122,
        ];
        $response = $this->post(route('groups.store', $this->account), $data)
        ->assertStatus(302);
        $this->assertDatabaseHas('groups', $data);
    }

    /**
     * @test
     */
    public function test_failed_store()
    {
        $data = [];
        $response = $this->post(route('groups.store', $this->account), $data);

        $response->assertRedirect();
        $this->assertEquals(session('errors')->get('name')[0], 'The name field is required.');
    }

    /**
     * @test
     */
    public function test_edit()
    {
        $group = Group::factory()->for($this->account)->create();
        $this->get(route('groups.edit', [$this->account, $group]))
        ->assertOk()
        ->assertViewIs('groups.edit')
        ->assertViewHas('account')
        ->assertViewHas('group')
        ->assertViewHas('sites')
        ->assertViewHas('groups');
    }

    /**
     * @test
     */
    public function test_update_with_sites()
    {
        $site = Site::factory()->for($this->account)->create([
            'subscription_id' => $this->subscription->id,
        ]);

        $group = Group::factory()->for($this->account)->create();
        $data = [
            'name'=>'test group',
            'notes'=>55,
            'sites'=>[$site->id],
        ];
        $this->put(route('groups.update', [$this->account, $group]), $data)
                    ->assertStatus(302);
        $this->assertDatabaseHas('groups', ['name' => 'test group']);
        $this->assertDatabaseHas('group_site', ['group_id' => $group->id, 'site_id' => $site->id]);
    }

    /**
     * @test
     */
    public function test_update_with_no_sites()
    {
        $group = Group::factory()->for($this->account)->create();
        $data = [
            'name'=>'test group',
            'notes'=>55,
        ];
        $this->put(route('groups.update', [$this->account, $group]), $data)
                    ->assertStatus(302);
        $this->assertDatabaseHas('groups', ['name' => 'test group']);
        $this->assertDatabaseMissing('group_site', ['group_id' => $group->id]);
    }

    /**
     * @test
     */
    public function test_failed_update()
    {
        $group = Group::factory()->for($this->account)->create();
        $data = [];
        $response = $this->put(route('groups.update', [$this->account, $group]), $data);
        $response->assertRedirect();
        $this->assertEquals(session('errors')->get('name')[0], 'The name field is required.');
    }

    /**
     * @test
     */
    public function test_delete()
    {
        $group = Group::factory()->for($this->account)->create();
        $response = $this->delete(route('groups.destroy', [$this->account, $group]))
        ->assertStatus(302);
        $this->assertDatabaseMissing('groups', $group->toArray());
        $this->assertDatabaseMissing('group_site', ['group_id' => $group->id]);
    }
}
