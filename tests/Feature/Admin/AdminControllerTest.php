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
class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_index()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'admin',
        ]);

        $this->actingAs($user);

        $userSecond = User::factory()->create();
        $accountSecond = Account::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $accountSecond->id,
            'user_id' => $userSecond->id,
            'role' => 'owner',
        ]);

        $response = $this->get(route('dashboard.index', $account));

        $this->assertEquals($response->getStatusCode(), 200);
        $response->assertViewIs('admin.dashboard.index');
        $response->assertViewHas('accounts');
    }
}
