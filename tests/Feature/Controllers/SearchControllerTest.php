<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class SearchControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test__invoke()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        AccountUser::factory()->create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'owner',
        ]);

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'name' => 'Site test name',
        ]);

        Install::factory()->create([
            'site_id' => $site->id,
            'name' => 'Install test name',
            'type' => 'dev',
        ]);

        $response = $this->get(
            route('site.search', $account),
            [
                'query' => 'test',
            ]
        );

        $response->assertOk();
        $response->statusText('OK');
        $response->decodeResponseJson();
    }
}
