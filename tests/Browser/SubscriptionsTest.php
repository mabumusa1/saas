<?php

namespace Tests\Browser;

use App\Models\Plan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SubscriptionsTest extends DuskTestCase
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
    public function test_period_input()
    {
        $plan = Plan::whereId(2)->first();
        $this->browse(function (Browser $browser) use ($plan) {
            $browser->loginAs($this->user)
            ->visit(route('billing.manageSubscriptions', $this->account))
                ->assertSee('My Subscriptions')
                ->click('#contactsNumber')
                ->clickAndWaitForReload('#contactsNumber option[value="2"]')
                ->screenshot('input')
                ->assertValue('#contactsNumber', $plan->id)
                ->assertQueryStringHas('plan', $plan->id)
                ->assertQueryStringHas('period', 'month')
                ->assertSee($plan->display_name);
        });
    }
}
