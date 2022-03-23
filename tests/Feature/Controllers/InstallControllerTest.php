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
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_displays_view()
    {
        $account = Account::factory()->create();
        $site = Site::factory()->create([
            'account_id' => $account->id,
        ]);
        $install = Install::factory()->create([
            'site_id' => $site->id,
        ]);
        $this->user = User::factory()->create();
        $account->users()->attach($this->user->id, ['role' => 'owner']);
        $this->actingAs($this->user);
        $this->get(route('installs.show', ['account' => $account, 'install' => $install]))
            ->assertOk()
            ->assertViewIs('installs.show');
    }
}
