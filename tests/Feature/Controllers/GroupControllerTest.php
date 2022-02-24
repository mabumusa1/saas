<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\Group;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GroupController
 */
class GroupControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
        $data = [
            'q'=>'name',
        ];

        $response = $this->get(route('groups.index', $account), $data);
        $response->assertOk();
        $response->assertViewIs('groups.index');
        $response->assertViewHas('account');
    }

    /**
     * @test
     */
    public function create_displays_view()
    {
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
        $response = $this->get(route('groups.create', $account));
        $response->assertOk();
        $response->assertViewIs('groups.create');
        $response->assertViewHas('account');
    }

    /**
     * @test
     */
    public function test_successful_store()
    {
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
        $data = [
            'name'=>'admin',
            'notes'=>122,
        ];
        $response = $this->post(route('groups.store', $account), $data)
        ->assertStatus(302);
        $this->assertDatabaseHas('groups', $data);
    }

    /**
     * @test
     */
    public function test_failed_store()
    {
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
        $data = [];
        $response = $this->post(route('groups.store', $account), $data);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('errors')->get('name')[0], 'The name field is required.');
    }

    /**
     * @test
     */
    public function test_edit()
    {
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
        $group = Group::factory()->for($account)->create();
        $response = $this->get(route('groups.edit', [$account, $group]))
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
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
        $site = Site::factory()->for($account)->create();
        $group = Group::factory()->for($account)->create();
        $data = [
            'name'=>'test group',
            'notes'=>55,
            'sites'=>[$site->id],
        ];
        $response = $this->put(route('groups.update', [$account, $group]), $data)
                    ->assertStatus(302);
        $this->assertDatabaseHas('groups', ['name' => 'test group']);
        $this->assertDatabaseHas('group_site', ['group_id' => $group->id, 'site_id' => $site->id]);
    }

    /**
     * @test
     */
    public function test_update_with__no_sites()
    {
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
        $group = Group::factory()->for($account)->create();
        $data = [
            'name'=>'test group',
            'notes'=>55,
        ];
        $response = $this->put(route('groups.update', [$account, $group]), $data)
                    ->assertStatus(302);
        $this->assertDatabaseHas('groups', ['name' => 'test group']);
        $this->assertDatabaseMissing('group_site', ['group_id' => $group->id]);
    }

    /**
     * @test
     */
    public function test_failed_update()
    {
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
        $group = Group::factory()->for($account)->create();
        $data = [];
        $response = $this->put(route('groups.update', [$account, $group]), $data);
        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('errors')->get('name')[0], 'The name field is required.');
    }

    /**
     * @test
     */
    public function test_delete()
    {
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);
        $group = Group::factory()->for($account)->create();
        $response = $this->delete(route('groups.destroy', [$account, $group]))
        ->assertStatus(302);
        $this->assertDatabaseMissing('groups', $group->toArray());
        $this->assertDatabaseMissing('group_site', ['group_id' => $group->id]);
    }
}
