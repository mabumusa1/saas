<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_index()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->get(route('dashboard', $account));

        $response->assertOk();
        $response->assertViewIs('dashboard');
    }
}
