<?php

namespace Tests;

use App\Models\Account;
use App\Models\Backup;
use App\Models\Cashier\Subscription;
use App\Models\Contact;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Plan;
use App\Models\Site;
use App\Models\User;
use Event;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Cashier\Subscription as CashierSubscription;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected User $user;

    protected Account $account;

    protected Site $site;

    protected Install $install;

    protected Contact $contact;

    protected Domain $domain;

    protected Backup $backup;

    public function setUp():void
    {
        parent::setUp();
    }

    public function addAccount()
    {
        $this->user = User::factory()->create();
        $this->account = Account::factory()->create();
        $this->account->users()->sync([$this->user->id => ['role' => 'owner']]);
        $this->actingAs($this->user);
    }

    public function addSite($addDomain = false)
    {
        if (empty($this->account)) {
            $this->addAccount();
        }
        $this->site = Site::factory()->for($this->account)->create();
        $this->install = Install::factory()->for($this->site)->create(['name' => 'domain']);
        $this->contact = Contact::factory()->for($this->install)->create();

        if ($addDomain) {
            $this->domain = Domain::factory()
            ->for($this->install)
            ->create(['name' => 'domain.steercampaign.com', 'primary' => true, 'verified_at' => null]);
        }
    }

    public function addBackup()
    {
        if (empty($this->install)) {
            $this->addSite();
        }

        $this->backup = Backup::factory()
        ->for($this->install)
        ->create();
    }
}
