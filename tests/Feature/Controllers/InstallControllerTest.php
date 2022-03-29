<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InstallControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_displays_view()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create();
        $this->get(route('installs.show', ['account' => $this->account, 'install' => $install]))
            ->assertOk()
            ->assertViewIs('installs.show');
    }
}
