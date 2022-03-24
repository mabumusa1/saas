<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\Cashier\Subscription;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
        $this->subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $this->site = Site::factory()
        ->for($this->account)
        ->for($this->subscription)
        ->create([
            'name' => 'Site test name',
        ]);

        $this->install = Install::factory()
        ->for($this->site)
        ->create([
            'name' => 'Install test name',
            'type' => 'dev',
        ]);

        $this->contact = Contact::factory()
        ->for($this->install)
        ->create([
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'example@gmail.com',
            'phone' => '12345678',
        ]);
    }

    /**
     * @test
     */
    public function test_index_displays_view()
    {
        $response = $this->get(route('contacts.index', $this->account));

        $response->assertOk();
        $response->assertViewIs('contact.index');
    }

    /**
     * @test
     */
    public function test_edit_displays_view()
    {
        $response = $this->get(route('contacts.edit', ['account' => $this->account, 'contact' => $this->contact]));

        $response->assertOk();
        $response->assertViewIs('contact.edit');
        $response->assertViewHas('account');
        $response->assertViewHas('contact');
    }

    /**
     * @test
     */
    public function test_contact_update_fail_without_last_name()
    {
        $response = $this->put(route('contacts.update', ['account' => $this->account, 'contact' => $this->contact]), [
            'first_name' => 'First Name',
            'last_name' => '',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect();
        $this->assertEquals(session('errors')->get('last_name')[0], 'The last name field is required.');
    }

    /**
     * @test
     */
    public function test_contact_update()
    {
        $response = $this->put(route('contacts.update', ['account' => $this->account, 'contact' => $this->contact]), [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect();
        $this->assertEquals(session('status'), 'Contact has been updated!');
    }
}
