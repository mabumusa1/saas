<?php

namespace Tests\Browser\Pages;

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
        $this->browse(function (Browser $browser) {
            $browser
            ->loginAs($this->user)
            ->visit("/account/{$this->account->id}/sites")
            ->press('#show_env')
            ->assertAttributeContains('.env', 'class', 'd-none')
            ->press('#show_env')
            ->assertVisible('.env');
        });
    }

    public function testSortableItems()
    {
        $this->browse(function (Browser $browser) {
            $browser
            ->loginAs($this->user)
            ->visit("/account/{$this->account->id}/sites")
            ->press('#sortable')
            ->assertQueryStringHas('order', 'ASC')
            ->press('#sortable')
            ->assertQueryStringHas('order', 'DESC');
        });
    }
}
