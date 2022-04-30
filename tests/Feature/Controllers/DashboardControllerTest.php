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

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
    }

    /**
     * @test
     */
    public function test_index()
    {
        $response = $this->get(route('dashboard', $this->account));

        $response->assertOk();
        $response->assertViewIs('dashboard');
    }
}
