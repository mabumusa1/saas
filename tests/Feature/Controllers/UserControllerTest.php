<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class UserControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_displays_view()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $response = $this->get(route('users.index', $account));

        $response->assertOk();
        $response->assertViewIs('user.index');
        $response->assertViewHas('users');
    }

    /**
     * @test
     */
    public function create_displays_view()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $response = $this->get(route('users.create', $account));

        $response->assertOk();
        $response->assertViewIs('user.create');
        $response->assertViewHas('account');
    }

    /**
     * @test
     */
    public function user_store_fail_without_last_name()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $response = $this->post(route('users.store', $account), [
            'first_name' => 'First Name',
            'last_name' => '',
            'email' => 'test@example.com',
            'role' => 'test@example.com',
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('errors')->get('last_name')[0], 'The last name field is required.');
    }

    /**
     * @test
     */
    public function user_store()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $response = $this->post(route('users.store', $account), [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'test@example.com',
            'role' => 'owner',
            'password' => 'password',
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('status'), 'User successfully created!');
    }

    /**
     * @test
     */
    public function edit_displays_view()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();
        $user = User::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        $response = $this->get(route('users.edit', ['account' => $account, 'user' => $user]));

        $response->assertOk();
        $response->assertViewIs('user.edit');
        $response->assertViewHas('account');
        $response->assertViewHas('user');
    }

    /**
     * @test
     */
    public function user_update_fail_without_last_name()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $response = $this->put(route('users.update', ['account' => $account, 'user' => $user]), [
            'first_name' => 'First Name',
            'last_name' => '',
            'email' => 'test@example.com',
            'role' => 'test@example.com',
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('errors')->get('last_name')[0], 'The last name field is required.');
    }

    /**
     * @test
     */
    public function user_update()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $user = User::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        $response = $this->put(route('users.update', ['account' => $account, 'user' => $user]), [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'test@example.com',
            'role' => 'owner',
            'password' => 'password',
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('message'), 'User successfully updated!');
    }

    /**
     * @test
     */
    public function user_destroy_only_if_account_has_one_owner()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $user = User::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        $response = $this->delete(route('users.destroy', ['account' => $account, 'user' => $user]));

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('status'), 'Sorry  you  can not delete this user!');
    }

    /**
     * @test
     */
    public function user_destroy()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $user = User::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        $userSecond = User::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $userSecond->id,
            'role' => 'owner',
        ]);

        $response = $this->delete(route('users.destroy', ['account' => $account, 'user' => $user]));
        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('status'), 'User successfully deleted!');
    }
}
