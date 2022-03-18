<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Invite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Str;
use Tests\TestCase;

class InviteControllerTest extends TestCase
{
    public function test_index_redirects_to_login_without_authentication()
    {
        $account = Account::factory()->create();
        $invite = Invite::factory()->create([
            'account_id' => $account->id,
        ]);
        $user = User::factory()->create([
            'email' => $invite->email,
        ]);
        $response = $this->get(route('invites.index', $invite));

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('url.intended', route('invites.index', $invite));
    }

    public function test_index_redirects_to_register_without_user()
    {
        $account = Account::factory()->create();
        $invite = Invite::factory()->create([
            'account_id' => $account->id,
        ]);
        $response = $this->get(route('invites.index', $invite));

        $response->assertRedirect(route('register'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_displays_view()
    {
        $account = Account::factory()->create();
        $invite = Invite::factory()->create([
            'account_id' => $account->id,
        ]);
        $user = User::factory()->create([
            'email' => $invite->email,
        ]);
        $this->actingAs($user);
        $response = $this->get(route('invites.index', ['invite' => $invite->token]));

        $response->assertOk();
        $response->assertViewIs('auth.invitation');
    }

    public function test_index_fail_with_wrong_token()
    {
        $response = $this->get(route('invites.index', ['invite' => Str::random(10)]));

        $response->assertStatus(404);
    }

    public function test_accept_fail_with_wrong_token()
    {
        $response = $this->post(route('invites.accept', [
            'token' => Str::random(10),
        ]));

        $response->assertStatus(302);
    }

    public function test_accept_success()
    {
        $account = Account::factory()->create();
        $invite = Invite::factory()->create([
            'account_id' => $account->id,
        ]);
        $user = User::factory()->create([
            'email' => $invite->email,
        ]);
        $this->actingAs($user);
        $response = $this->post(route('invites.accept', [
            'token' => $invite->token,
        ]));

        $response->assertRedirect(route('home', ['account' => $account]));
    }
}
