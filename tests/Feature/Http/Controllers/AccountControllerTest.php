<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $accounts = Account::factory()->count(3)->create();

        $response = $this->get(route('account.index'));

        $response->assertOk();
        $response->assertViewIs('account.index');
        $response->assertViewHas('accounts');
    }

    /**
     * @test
     */
    public function show_displays_view()
    {
        $account = Account::factory()->create();

        $response = $this->get(route('account.show', $account));

        $response->assertOk();
        $response->assertViewIs('account.show');
        $response->assertViewHas('show');
    }
}
