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

    private $adminUser;

    private $adminAccount;

    public function setUp():void
    {
        parent::setUp();
        parent::addAccount();

        $this->adminUser = User::factory()->create();
        $this->adminAccount = Account::factory()->create();
        $this->adminAccount->users()->sync([$this->adminUser->id => ['role' => 'admin']]);
        $this->actingAs($this->adminUser);
    }

    /**
     * @test
     */
    public function test_login_as_admin()
    {
        $response = $this->get(route('admin.dashboard', $this->adminAccount));
        $response->assertSuccessful();
        $response->assertViewIs('admin.index');
        $response->assertViewHas('accounts');
    }

    /**
     * @test
     */
    public function test_admin_can_impersonate_and_leave()
    {
        $this->actingAs($this->user);
        $response = $this->get(route('impersonate', $this->user->id));
        $response->assertForbidden();

        $this->actingAs($this->adminUser);
        $response = $this->get(route('impersonate', $this->user->id));
        $response->assertRedirectContains(route('home'));

        $response = $this->get(route('dashboard', $this->account->id));
        $response->assertSuccessful();

        $response = $this->get(route('impersonate.leave'));
        $response->assertRedirectContains(route('home'));
    }
}
