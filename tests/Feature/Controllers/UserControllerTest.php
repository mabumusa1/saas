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

    /**
     * @test
     */
    public function test_index_displays_view()
    {
        parent::setUpAccount();
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
        parent::setUpAccount();
        $view = $this->view('layout.aside._menu');

        $view->assertSee($this->account->name);
    }

    /**
     * @test
     */
    public function test_create_displays_view()
    {
        parent::setUpAccount();
        $response = $this->get(route('users.create', $this->account));

        $response->assertOk();
        $response->assertViewIs('user.create');
        $response->assertViewHas('account');
    }

    public function test_user_store_fails_for_existing_user()
    {
        parent::setUpAccount();
        $user = User::factory()->create();
        $this->account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->post(route('users.store', $this->account), [
            'email' => $user->email,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_store_fails_for_existing_invite()
    {
        parent::setUpAccount();
        $invite = Invite::factory()->for($this->account)->create();

        $response = $this->post(route('users.store', $this->account), [
            'email' => $invite->email,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_store_success()
    {
        Event::fake();
        parent::setUpAccount();
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
        parent::setUpAccount();

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
    public function test_user_destroy_only_if_account_has_one_owner()
    {
        parent::setUpAccount(false);
        $response = $this->delete(route('users.destroy', ['account' => $this->account, 'user' => $this->user]));
        $this->actingAs($this->user);
        $response->assertRedirect();
    }

    /**
     * @test
     */
    public function test_user_destroy()
    {
        parent::setUpAccount();
        $userSecond = User::factory()->create();
        $this->account->users()->attach($userSecond->id, ['role' => 'owner']);

        $response = $this->delete(route('users.destroy', ['account' => $this->account, 'user' => $this->user]));
        $response->assertRedirect();
    }
}
