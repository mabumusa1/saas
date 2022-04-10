<?php

namespace Tests\Feature\Controllers;

use App\Events\UserInvitedEvent;
use App\Listeners\UserInvitedListener;
use App\Models\Account;
use App\Models\Invite;
use App\Models\User;
use App\Notifications\InviteNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
    }

    /**
     * @test
     */
    public function test_index_displays_view()
    {
        $response = $this->get(route('users.index', $this->account));

        $response->assertOk();
        $response->assertViewIs('user.index');
        $response->assertViewHas('users');
    }

    /**
     * @test
     */
    public function test_index_displays_view_without_account_set()
    {
        $view = $this->view('layout.aside._menu');

        $view->assertSee($this->account->name);
    }

    /**
     * @test
     */
    public function test_create_displays_view()
    {
        $response = $this->get(route('users.create', $this->account));

        $response->assertOk();
        $response->assertViewIs('user.create');
        $response->assertViewHas('account');
    }

    public function test_user_store_fails_for_existing_user()
    {
        $user = User::factory()->create();
        $this->account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->post(route('users.store', $this->account), [
            'email' => $user->email,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_store_fails_for_existing_invite()
    {
        $invite = Invite::factory()->for($this->account)->create();

        $response = $this->post(route('users.store', $this->account), [
            'email' => $invite->email,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_store_success()
    {
        Event::fake();
        $response = $this->post(route('users.store', $this->account), [
            'email' => 'test@a.com',
            'role' => 'owner',
        ]);

        $response->assertRedirect(route('users.index', $this->account));
        $this->assertDatabaseHas('invites', [
            'email' => 'test@a.com',
            'role' => 'owner',
        ]);

        Event::assertDispatched(UserInvitedEvent::class);
    }

    /**
     * @test
     */
    public function test_user_update()
    {
        $user = User::factory()->create();
        $this->account->users()->attach($user->id, ['role' => 'fb']);
        $response = $this->put(route('users.update', ['account' => $this->account, 'user' => $user]), [
            'role' => 'pb',
        ]);

        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_user_update_not_allowed()
    {
        $user = User::factory()->create();
        $this->account->users()->attach($user->id, ['role' => 'fb']);
        $this->actingAs($user);

        $response = $this->put(route('users.update', ['account' => $this->account, 'user' => $user]), [
            'role' => 'pb',
        ]);

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function test_user_destroy_not_allowed()
    {
        $user = User::factory()->create();
        $this->account->users()->attach($user->id, ['role' => 'fb']);
        $this->actingAs($user);

        $response = $this->delete(route('users.destroy', ['account' => $this->account, 'user' => $user]));

        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function test_user_destroy_only_if_account_has_one_owner()
    {
        $response = $this->delete(route('users.destroy', ['account' => $this->account, 'user' => $this->user]));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function test_user_destroy()
    {
        $userSecond = User::factory()->create();
        $this->account->users()->attach($userSecond->id, ['role' => 'owner']);
        $this->actingAs($userSecond);
        $response = $this->delete(route('users.destroy', ['account' => $this->account, 'user' => $this->user]));
        $response->assertRedirect();
    }
}
