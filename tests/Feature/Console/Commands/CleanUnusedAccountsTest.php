<?php

namespace Tests\Feature\Console;

use App\Jobs\VerifyDomain;
use App\Models\Account;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CleanUnusedAccountsTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_unverified_users_command()
    {
        $date = new \Carbon\Carbon();
        $firstOfDay = $date->floorDay();
        $this->travelTo($firstOfDay);
        $this->user = User::factory()->create(['email_verified_at' => null, 'created_at' => now()->subDays(35)]);
        $this->account = $this->user->accounts()->first();
        $this->artisan('accounts:clean');

        $this->assertDatabaseMissing('users', [
            'email' => $this->user->email,
        ]);
        $this->assertDatabaseMissing('accounts', [
            'id' => $this->account->id,
        ]);
    }
}
