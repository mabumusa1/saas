<?php

namespace Tests\Browser;

use App\Models\Cashier\Subscription;
use App\Models\Plan;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SiteCreateTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();
        parent::addAccount();
        parent::addSite();
    }

    private function createSubscription()
    {
        $plan = Plan::first();
        Subscription::factory()->create([
            'name' => $plan->name,
            'account_id' => $this->account->id,
            'quantity' => 1,
        ]);
    }

    public function test_create_must_be_disable_when_no_subscription_and_no_quota()
    {
        $this->browse(function (Browser $browser) {
            $browser
            ->loginAs($this->user)
            ->visit(route('sites.create', $this->account))
            ->assertSee('Who owns the site?');
            $browser
            ->mouseover('form#site-form')
            ->assertSee("You don't have active subscriptions or Quota Please Consider Adding One");
        });
    }

    public function test_user_must_not_processed_when_no_install_selected()
    {
        $this->createSubscription();
        $this->browse(function (Browser $browser) {
            $browser
            ->loginAs($this->user)
            ->visit(route('sites.create', $this->account))
            ->assertSee('Who owns the site?');
            $browser
            ->click('label[for="start_copy"]')
            ->click('button[data-kt-stepper-action="next"]')
            ->assertSee('Please select a valid Install.');
        });
    }

    public function test_form_validation_when_sitename_and_installname_are_empty()
    {
        $this->createSubscription();
        $this->browse(function (Browser $browser) {
            $browser
            ->loginAs($this->user)
            ->visit(route('sites.create', $this->account))
            ->assertSee('Who owns the site?');
            $browser
            ->click('button[data-kt-stepper-action="next"]')
            ->assertSee('Site name and first install')
            ->click('button#btn-submit')
            ->assertSee('Site name is required')
            ->assertSee('Install name is required')
            ->assertSee('The install name should be a valid URL');
        });
    }

    public function test_create_works()
    {
        $this->createSubscription();
        $this->browse(function (Browser $browser) {
            $browser
            ->loginAs($this->user)
            ->visit(route('sites.create', $this->account))
            ->assertSee('Who owns the site?');
            $browser
            ->click('button[data-kt-stepper-action="next"]')
            ->assertSee('Site name and first install')
            ->type('sitename', 'test')
            ->type('installname', 'test')
            ->clickAndWaitForReload('button#btn-submit');
            $site = $this->account->sites->get(1);
            $install = $this->account->sites->get(1);
            $browser->assertRouteIs('installs.show', [$this->account, $site, $install]);
        });
    }
}
