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

    public function setUp():void
    {
        parent::setUp();
        $this->addAccount();
    }

    /**
     * Can Login.
     *
     * @return void
     */
    public function test_login()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                    ->type('email', $this->user->email)
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertRouteIs('dashboard', ['account' => $this->account->id]);
        });
    }

    /**
     * Can Logout.
     *
     * @return void
     */
    public function test_logout()
    {
        $this->browse(function ($browser) {
            $browser->loginAs($this->user)
            ->visit('/logout')->logout()
            ->assertGuest();
        });
    }

    /**
     * Can Register.
     *
     * @return void
     */
    public function test_register()
    {
        $this->browse(function ($browser) {
            $browser->visit('/register')
                    ->type('first_name', 'First Name')
                    ->type('last_name', 'Last Name')
                    ->type('email', 'email@domain.com')
                    ->type('password', 'password@1234')
                    ->type('password_confirmation', 'password@1234')
                    ->check('terms')
                    ->press('Register')
                    ->assertSee('Resend Verification Email');
        });
    }
}
