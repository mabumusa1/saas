<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_contact_install() : void
    {
        $account = Account::factory()->create();
        $site = Site::factory()->create(['account_id' => $account->id]);
        $install = Install::factory()->create(['site_id' => $site->id]);
        $contact = Contact::factory()->create(['install_id' => $install->id]);
        $this->assertEquals($contact->install->name, $install->name);
    }

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_contact_name() : void
    {
        $account = Account::factory()->create();
        $site = Site::factory()->create(['account_id' => $account->id]);
        $install = Install::factory()->create(['site_id' => $site->id]);
        $contact = Contact::factory()->create(['install_id' => $install->id, 'first_name' => 'test', 'last_name' => 'Test']);
        $this->assertEquals($contact->fullName, 'Test Test');
    }
}
