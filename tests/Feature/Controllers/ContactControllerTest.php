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

    /**
     * @test
     */
    public function test_index_displays_view()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();
        $account->users()->attach($user->id, ['role' => 'owner']);

        $this->actingAs($user);
        $response = $this->get(route('contacts.index', $account));

        $response->assertOk();
        $response->assertViewIs('contact.index');
    }

    /**
     * @test
     */
    public function test_edit_displays_view()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();
        $account->users()->attach($user->id, ['role' => 'owner']);

        $subscription = new Subscription();
        $subscription->account_id = $account->id;
        $subscription->name = 'test';
        $subscription->stripe_id = 'test';
        $subscription->stripe_status = 'test';
        $subscription->stripe_price = 'test';
        $subscription->quantity = 1;
        $subscription->trial_ends_at = null;
        $subscription->ends_at = now();
        $subscription->save();

        $subscription = Subscription::factory()->create([

        ]);
        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
            'name' => 'Site test name',
        ]);

        $install = Install::factory()->create([
            'site_id' => $site->id,
            'name' => 'Install test name',
            'type' => 'dev',
        ]);

        $this->actingAs($user);

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
        $account = Account::factory()->create();
        $user = User::factory()->create();
        $account->users()->attach($user->id, ['role' => 'owner']);

        $subscription = new Subscription();
        $subscription->account_id = $account->id;
        $subscription->name = 'test';
        $subscription->stripe_id = 'test';
        $subscription->stripe_status = 'test';
        $subscription->stripe_price = 'test';
        $subscription->quantity = 1;
        $subscription->trial_ends_at = null;
        $subscription->ends_at = now();
        $subscription->save();

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
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

        $this->actingAs($user);

        $response = $this->put(route('contacts.update', ['account' => $account, 'contact' => $contact]), [
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
        $account = Account::factory()->create();
        $user = User::factory()->create();
        $account->users()->attach($user->id, ['role' => 'owner']);

        $subscription = new Subscription();
        $subscription->account_id = $account->id;
        $subscription->name = 'test';
        $subscription->stripe_id = 'test';
        $subscription->stripe_status = 'test';
        $subscription->stripe_price = 'test';
        $subscription->quantity = 1;
        $subscription->trial_ends_at = null;
        $subscription->ends_at = now();
        $subscription->save();

        $site = Site::factory()->create([
            'account_id' => $account->id,
            'subscription_id' => $subscription->id,
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

        $this->actingAs($user);

        $response = $this->put(route('contacts.update', ['account' => $account, 'contact' => $contact]), [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect();
        $this->assertEquals(session('status'), 'Contact has been updated!');
    }
}
