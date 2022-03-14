<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class UserControllerTest extends TestCase
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

        $response = $this->get(route('users.index', $account));

        $response->assertOk();
        $response->assertViewIs('user.index');
        $response->assertViewHas('users');
    }

    /**
     * @test
     */
    public function test_create_displays_view()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->get(route('users.create', $account));

        $response->assertOk();
        $response->assertViewIs('user.create');
        $response->assertViewHas('account');
    }

    /**
     * @test
     */
    public function test_user_store_fail_without_last_name()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->post(route('users.store', $account), [
            'first_name' => 'First Name',
            'last_name' => '',
            'email' => 'test@example.com',
            'role' => 'test@example.com',
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_user_store()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->post(route('users.store', $account), [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'test@example.com',
            'role' => 'owner',
            'password' => 'password',
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_edit_403_for_single_owner()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->get(route('users.edit', ['account' => $account, 'user' => $user]));

        $response->assertOk();
    }

    /**
     * @test
     */
    public function test_edit_displays_view()
    {
        $this->actingAs($user = User::factory()->create());
        $user2 = User::factory()->create();

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->get(route('users.edit', ['account' => $account, 'user' => $user]));

        $response->assertOk();
        $response->assertViewIs('user.edit');
        $response->assertViewHas('user');
    }

    /**
     * @test
     */
    public function test_user_update_fail_without_last_name()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->put(route('users.update', ['account' => $account, 'user' => $user]), [
            'first_name' => 'First Name',
            'last_name' => '',
            'email' => 'test@example.com',
            'role' => 'test@example.com',
        ]);

        $response->assertRedirect();
        $this->assertEquals(session('errors')->get('last_name')[0], 'The last name field is required.');
    }

    /**
     * @test
     */
    public function test_user_update()
    {
        $account = Account::factory()->create();

        $user = User::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);
        $this->actingAs($user);

        $response = $this->put(route('users.update', ['account' => $account, 'user' => $user]), [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'test@example.com',
            'role' => 'owner',
            'password' => 'password',
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_user_destroy_only_if_account_has_one_owner()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();
        $account->users()->attach($user->id, ['role' => 'pb']);

        $response = $this->delete(route('users.destroy', ['account' => $account, 'user' => $user]));
        $this->actingAs($user);
        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_user_destroy()
    {
        $account = Account::factory()->create();

        $user = User::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);
        $this->actingAs($user);

        $userSecond = User::factory()->create();
        $account->users()->attach($userSecond->id, ['role' => 'owner']);

        $response = $this->delete(route('users.destroy', ['account' => $account, 'user' => $user]));
        $response->assertRedirect();
    }
}
