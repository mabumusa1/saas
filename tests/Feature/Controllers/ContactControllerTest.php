<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
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

    /**
     * @test
     */
    public function test_index_displays_view()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $response = $this->get(route('contacts.index', $account));

        $response->assertOk();
        $response->assertViewIs('contact.index');
    }

    /**
     * @test
     */
    public function test_edit_displays_view()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'name' => 'Site test name',
        ]);

        $install = Install::factory()->create([
            'site_id' => $site->id,
            'name' => 'Install test name',
            'type' => 'dev',
        ]);

        $contact = Contact::factory()->create([
            'install_id' => $install->id,
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'example@gmail.com',
            'phone' => '12345678',
        ]);

        $response = $this->get(route('contacts.edit', ['account' => $account, 'contact' => $contact]));

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
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'name' => 'Site test name',
        ]);

        $install = Install::factory()->create([
            'site_id' => $site->id,
            'name' => 'Install test name',
            'type' => 'dev',
        ]);

        $contact = Contact::factory()->create([
            'install_id' => $install->id,
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'example@gmail.com',
            'phone' => '12345678',
        ]);

        $response = $this->put(route('contacts.update', ['account' => $account, 'contact' => $contact]), [
            'first_name' => 'First Name',
            'last_name' => '',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('errors')->get('last_name')[0], 'The last name field is required.');
    }

    /**
     * @test
     */
    public function test_contact_update()
    {
        $this->actingAs($user = User::factory()->create());

        $account = Account::factory()->create();

        $account->users()->attach($user->id, ['role' => 'owner']);

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'name' => 'Site test name',
        ]);

        $install = Install::factory()->create([
            'site_id' => $site->id,
            'name' => 'Install test name',
            'type' => 'dev',
        ]);

        $contact = Contact::factory()->create([
            'install_id' => $install->id,
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'example@gmail.com',
            'phone' => '12345678',
        ]);

        $response = $this->put(route('contacts.update', ['account' => $account, 'contact' => $contact]), [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'test@example.com',
        ]);

        $this->assertEquals($response->getStatusCode(), 302);
        $this->assertEquals(session('status'), 'Contact has been updated!');
    }
}
