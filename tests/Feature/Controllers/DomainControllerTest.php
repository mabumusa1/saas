<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DomainControllerTest extends TestCase
{
    use RefreshDatabase;

    private $install;

    private $site;

    private $domain;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
        $this->site = Site::factory()->for($this->account)->create();
        $this->install = Install::factory()
        ->for($this->site)
        ->create(['name' => 'domain']);
        $this->domain = Domain::factory()
        ->for($this->install)
        ->create(['name' => 'domain.steercampaign.com', 'primary' => true]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_domains_index()
    {
        $this->get(route('domains.index', [$this->account, $this->site, $this->install]))
        ->assertOk()
        ->assertViewIs('installs.domains.index');
    }

    public function test_domains_store_success()
    {
        $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'domain.com'])
        ->assertRedirect();

        $this->assertDatabaseHas('domains', [
            'name' => 'domain.com',
        ]);
    }

    public function test_domains_store_json_validation()
    {
        $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'domain.com', 'isValidation' => true])
        ->assertJsonPath('valid', true);
    }

    public function test_domains_store_invalid_domain_name()
    {
        $response = $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'steercampaig[]n']);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_domains_store_validation_same_account()
    {
        $response = $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'domain.steercampaign.com']);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_domains_store_validation_another_account()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();
        $account->users()->attach($user->id, ['role' => 'owner']);
        $site = Site::factory()->for($account)->create();
        $install = Install::factory()
        ->for($site)
        ->create();
        $domain = Domain::factory()
        ->for($install)
        ->create(['name' => 'x.steercampaign.com', 'primary' => true]);
        $response = $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'x.steercampaign.com']);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_domains_destroy_can_not_delete_builtin()
    {
        $response = $this->delete(route('domains.destroy', [$this->account, $this->site, $this->install, $this->domain]))
        ->assertUnauthorized();
    }

    public function test_domains_destroy_change_primary()
    {
        $domain = Domain::factory()
        ->for($this->install)
        ->create(['name' => 'x.com', 'primary' => true]);
        $this->domain->primary = false;
        $this->domain->save();

        $response = $this->delete(route('domains.destroy', [$this->account, $this->site, $this->install, $domain]))
        ->assertRedirect();

        $this->assertDatabaseMissing('domains', [
            'name' => 'x.com',
        ]);
    }

    public function test_domains_redirect()
    {
        $domain = Domain::factory()
        ->for($this->install)
        ->create(['name' => 'x.com', 'primary' => true]);
        $this->domain->primary = false;
        $this->domain->save();

        $response = $this->post(route('domains.redirect', [$this->account, $this->site, $this->install]), [
            'domain' => $this->domain->id,
            'dest' => $domain->id,
        ])
        ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('domains', [
            'name' => $this->domain->name,
            'redirect_to' => $domain->name,
        ]);
    }

    public function test_domains_redirect_none()
    {
        $this->domain->redirect_to = 'test';
        $this->domain->save();

        $response = $this->post(route('domains.redirect', [$this->account, $this->site, $this->install]), [
            'domain' => $this->domain->id,
        ])
        ->assertRedirect();

        $this->assertDatabaseHas('domains', [
            'name' => $this->domain->name,
            'redirect_to' => null,
        ]);
    }

    public function test_domains_set_primary()
    {
        $domain = Domain::factory()
        ->for($this->install)
        ->create(['name' => 'x.com', 'primary' => true]);
        $this->domain->primary = false;
        $this->domain->save();

        $this->domain->primary = false;
        $this->domain->save();

        $response = $this->post(route('domains.setPrimary', [$this->account, $this->site, $this->install, $this->domain]))
        ->assertRedirect();

        $this->assertDatabaseHas('domains', [
            'name' => $this->domain->name,
            'primary' => true,
        ]);
    }
}
