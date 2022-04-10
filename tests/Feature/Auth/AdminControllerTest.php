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

    private $normalUser;

    private $adminUser;

    public function setUp():void
    {
        parent::setUp();

        $this->normalUser = User::factory()->create();
        $this->adminUser = User::factory()->create();
        $adminAccount = $this->adminUser->accounts()->first();
        $adminAccount->users()->sync([$this->adminUser->id => ['role' => 'admin']]);

        $this->actingAs($this->adminUser);
    }

    /**
     * @test
     */
    public function test_login_as_admin()
    {
        $response = $this->get(route('admin.dashboard', $this->adminUser->accounts()->first()));
        $this->assertEquals($response->getStatusCode(), 200);
        $response->assertViewIs('admin.index');
        $response->assertViewHas('accounts');
    }

    /**
     * @test
     */
    public function test_admin_can_impersonate_and_leave()
    {
        $response = $this->get(route('impersonate', $this->normalUser->id));
        $response->assertStatus(302);

        $response = $this->get(route('dashboard', $this->adminUser));
        $response->assertStatus(200);

        $response = $this->get(route('impersonate.leave'));
        $response->assertStatus(302);

        $response = $this->get(route('admin.dashboard', $this->adminUser->accounts()->first()));
    }
}
