<?php

namespace Tests\Browser;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AuthTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * Can Login.
     *
     * @return void
     */
    public function test_login()
    {
        Account::factory()->hasAttached(
            User::factory()
            ->sequence(
                fn ($sequence) => ['email' => "email{$sequence->index}@domain.com"]
            )
        )->create();

        $user = User::where('email', 'email0@domain.com')->first();

        $this->browse(function ($browser) use ($user) {
            $browser->screenshot('filename');
            $browser->visit('/login')
                    ->type('email', $user->email)
                    ->type('password', 'password')
                    ->press('Continue')
                    ->assertPathIs('/1/admin/dashboard');
        });
    }
}
