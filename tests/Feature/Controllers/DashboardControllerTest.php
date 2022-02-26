<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\AccountUser;
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

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        $response = $this->get(route('dashboard', $account));

        $response->assertOk();
        $response->assertViewIs('dashboard');
    }
}
