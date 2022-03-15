<?php

namespace Tests\Feature\Auth;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_login_as_admin()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();
        $account->users()->attach($user->id, ['role' => 'admin']);
        $this->actingAs($user);

        $response = $this->get(route('admin.dashboard', $account));

        $this->assertEquals($response->getStatusCode(), 200);
        $response->assertViewIs('admin.index');
        $response->assertViewHas('accounts');
    }

    /**
     * @test
     */
    public function test_admin_can_impersonate_and_leave()
    {
        $normalAccount = Account::factory()->create();
        $normalUser = User::factory()->create();
        $normalAccount->users()->attach($normalUser->id, ['role' => 'owner']);

        $adminAccount = Account::factory()->create();
        $adminUser = User::factory()->create();
        $adminAccount->users()->attach($adminUser->id, ['role' => 'admin']);

        $this->actingAs($adminUser);

        $response = $this->get(route('impersonate', $normalUser->id));
        $response->assertStatus(302);

        $response = $this->get(route('dashboard', $adminUser));
        $response->assertStatus(200);

        $response = $this->get(route('impersonate.leave'));
        $response->assertStatus(302);

        $response = $this->get(route('admin.dashboard', $adminAccount));
    }
}
