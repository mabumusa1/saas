<?php

namespace Tests\Browser;

use App\Models\Group;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GroupEditTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        parent::addAccount();
        parent::addSite();
    }

    public function test_group_edit()
    {
        $group = Group::factory()->for($this->account)->create();
        $this->browse(function (Browser $browser) use ($group) {
            $browser->loginAs($this->user)
            ->visit(route('groups.edit', ['account' => $this->account, 'group' => $group]))
            ->assertSee('Edit Group')
            ->click('#selectAll')
            ->assertChecked('.site')
            ->click('#removeAll')
            ->assertNotChecked('.site');
        });
    }
}
