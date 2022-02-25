<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_authenticate_without_password()
    {
        $user = User::factory()->create();

        $account = Account::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        $response = $this->post(route('post.login'), [
            'email' => 'test@email.com',
            'password' => '',
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('errors')->get('password')[0], 'The password field is required.');
    }

    /**
     * @test
     */
    public function test_authenticate()
    {
        $user = User::factory()->create();

        $account = Account::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        $response = $this->post(route('post.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        $this->assertEquals($response->getStatusCode(), 302);
        $this->followingRedirects();
    }
}
