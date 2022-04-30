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

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
    }

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_contact_install() : void
    {
        $this->assertEquals($this->contact->install->name, $this->install->name);
    }

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_contact_name() : void
    {
        $this->contact->first_name = 'test';
        $this->contact->last_name = 'Test';
        $this->contact->save();

        $this->assertEquals($this->contact->fullName, 'Test Test');
    }
}
