<?php

namespace Tests\Browser;

use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SiteIndexTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();
        parent::addAccount();
        parent::addSite();
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testShowInstallCheckbox()
    {
        $user = $this->user;
        $account = $this->account;
        $this->browse(function (Browser $browser) use ($user, $account) {
            $browser
            ->loginAs($user)
            ->visit("/account/{$account->id}/sites")
            ->press('#show_env')
            ->assertAttributeContains('.env', 'class', 'd-none')
            ->press('#show_env')
            ->assertVisible('.env');
        });
    }

    public function testSortableItems()
    {
        $user = $this->user;
        $account = $this->account;

        $this->browse(function (Browser $browser) use ($user, $account) {
            $browser
            ->loginAs($user)
            ->visit("/account/{$account->id}/sites")
            ->press('#sortable')
            ->assertQueryStringHas('order', 'ASC')
            ->press('#sortable')
            ->assertQueryStringHas('order', 'DESC');
        });
    }
}
