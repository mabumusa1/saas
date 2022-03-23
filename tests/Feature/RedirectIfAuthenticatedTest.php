<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RedirectIfAuthenticatedTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_middleware()
    {
        $this->actingAs($user = User::factory()->create());
        $account = Account::factory()->create();
        $account->users()->attach($user->id, ['role' => 'owner']);
        $response = $this->post(route('login'))->assertRedirect('/');
    }
}
