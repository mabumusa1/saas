<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Spatie\Dns\Records\TXT;
use Tests\TestCase;

class DomainControllerTest extends TestCase
{
    use RefreshDatabase;

    private Account $otherAccount;

    private User $otherUser;

    private Site $otherSite;

    private Install $otherInstall;

    private Domain $otherDomain;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite(true);

        $this->otherAccount = Account::withoutEvents(function () {
            return Account::factory()->create();
        });
        $otherAccount = $this->otherAccount;

        $this->otherUser = User::withoutEvents(function () {
            return User::factory()->create();
        });

        $this->otherSite = Site::withoutEvents(function () use ($otherAccount) {
            return Site::factory()->for($otherAccount)->create();
        });

        $otherSite = $this->otherSite;
        $this->otherInstall = Install::withoutEvents(function () use ($otherSite) {
            return Install::factory()->for($otherSite)->create();
        });
        $otherInstall = $this->otherInstall;
        $this->otherDomain = Domain::withoutEvents(function () use ($otherInstall) {
            return Domain::factory()
            ->for($otherInstall)
            ->create(['name' => 'x.'.env('CNAME_DOMAIN'), 'primary' => true]);
        });

        $this->otherAccount->users()->attach($this->otherUser->id, ['role' => 'owner']);
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
        $response = $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'domain.'.env('CNAME_DOMAIN')]);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_domains_store_validation_another_account()
    {
        $response = $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'x.'.env('CNAME_DOMAIN')]);
        $response->assertSessionHasErrors(['name']);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_domains_store_validation_same_domain_verified()
    {
        $this->dnsMock = Mockery::mock('overload:Spatie\Dns\Dns');
        $this->dnsMock = $this->dnsMock->shouldReceive('useNameserver')
        ->once()
        ->andReturnSelf();
        $dnsResponse = [
            new TXT([
                'host' => 'm.iabaustralia.com.au',
                'ttl' => 3600,
                'class' => 'IN',
                'type' => 'TXT',
                'txt'=> "sc-verification={$this->install->name}",
            ]),
        ];
        $this->dnsMock->shouldReceive('getRecords')
        ->once()
        ->withArgs([$this->domain->name, 'TXT'])
        ->andReturn($dnsResponse);

        $response = $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'domain.'.env('CNAME_DOMAIN')]);
        $this->assertDatabaseHas('domains', [
            'install_id' => $this->install->id,
            'name' => 'domain.'.env('CNAME_DOMAIN'),
        ]);

        $response->assertRedirect();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_domains_store_validation_same_domain_not_verified()
    {
        $this->dnsMock = Mockery::mock('overload:Spatie\Dns\Dns');
        $this->dnsMock = $this->dnsMock->shouldReceive('useNameserver')
        ->once()
        ->andReturnSelf();
        $dnsResponse = [
            new TXT([
                'host' => 'm.iabaustralia.com.au',
                'ttl' => 3600,
                'class' => 'IN',
                'type' => 'TXT',
                'txt'=> 'sc-verification=notright',
            ]),
        ];
        $this->dnsMock->shouldReceive('getRecords')
        ->once()
        ->withArgs([$this->domain->name, 'TXT'])
        ->andReturn($dnsResponse);

        $response = $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'domain.'.env('CNAME_DOMAIN')]);
        $this->assertDatabaseHas('domains', [
            'install_id' => $this->install->id,
            'name' => 'domain.'.env('CNAME_DOMAIN'),
        ]);
        $response->assertSessionHasErrors(['name']);
        $response->assertRedirect();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_domain_added_another_account_not_verified()
    {
        $otherAccount = Account::withoutEvents(function () {
            return Account::factory()->create();
        });
        $otherSite = Site::withoutEvents(function () use ($otherAccount) {
            return Site::factory()->for($otherAccount)->create();
        });
        $otherInstall = Install::withoutEvents(function () use ($otherSite) {
            return Install::factory()->for($otherSite)->create(['name' => 'iab', 'type' => 'dev']);
        });
        $otherDomain = Domain::withoutEvents(function () use ($otherInstall) {
            return Domain::factory()
                ->for($otherInstall)
                ->create(['name' => 'm.iabaustralia.com.au', 'primary' => false, 'verified_at' => null]);
        });

        $this->dnsMock = Mockery::mock('overload:Spatie\Dns\Dns');
        $this->dnsMock = $this->dnsMock->shouldReceive('useNameserver')
        ->once()
        ->andReturnSelf();

        $dnsResponse = [
            new TXT([
                'host' => 'm.iabaustralia.com.au',
                'ttl' => 3600,
                'class' => 'IN',
                'type' => 'TXT',
                'txt'=> "sc-verification={$this->install->name}",
            ]),
        ];
        $this->dnsMock->shouldReceive('getRecords')
        ->once()
        ->withArgs(['m.iabaustralia.com.au', 'TXT'])
        ->andReturn($dnsResponse);

        $response = $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'm.iabaustralia.com.au']);

        $this->assertDatabaseMissing('domains', [
            'install_id' => $otherInstall->id,
            'name' => 'm.iabaustralia.com.au',
        ]);
        $response->assertRedirect();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_domain_added_another_account_not_verified_error()
    {
        $otherAccount = Account::withoutEvents(function () {
            return Account::factory()->create();
        });
        $otherSite = Site::withoutEvents(function () use ($otherAccount) {
            return Site::factory()->for($otherAccount)->create();
        });
        $otherInstall = Install::withoutEvents(function () use ($otherSite) {
            return Install::factory()->for($otherSite)->create(['name' => 'iab', 'type' => 'dev']);
        });
        $otherDomain = Domain::withoutEvents(function () use ($otherInstall) {
            return Domain::factory()
                ->for($otherInstall)
                ->create(['name' => 'm.iabaustralia.com.au', 'primary' => false, 'verified_at' => null]);
        });

        $this->dnsMock = Mockery::mock('overload:Spatie\Dns\Dns');
        $this->dnsMock = $this->dnsMock->shouldReceive('useNameserver')
        ->once()
        ->andReturnSelf();

        $dnsResponse = [
            new TXT([
                'host' => 'm.iabaustralia.com.au',
                'ttl' => 3600,
                'class' => 'IN',
                'type' => 'TXT',
                'txt'=> 'sc-verification=error',
            ]),
        ];
        $this->dnsMock->shouldReceive('getRecords')
        ->once()
        ->withArgs(['m.iabaustralia.com.au', 'TXT'])
        ->andReturn($dnsResponse);

        $response = $this->post(route('domains.store', [$this->account, $this->site, $this->install]), ['name' => 'm.iabaustralia.com.au']);
        $this->assertDatabaseHas('domains', [
            'install_id' => $this->install->id,
            'name' => 'domain.'.env('CNAME_DOMAIN'),
        ]);
        $response->assertSessionHasErrors(['name']);

        $response->assertRedirect();
    }

    public function test_domains_destroy_can_not_delete_builtin()
    {
        $this->install->name = 'domain';
        $this->install->save();
        $response = $this->delete(route('domains.destroy', [$this->account, $this->site, $this->install, $this->domain]))
        ->assertUnauthorized();
    }

    public function test_domains_destroy_change_primary()
    {
        $domain = Domain::factory()
        ->for($this->install)
        ->create(['name' => 'x.com', 'primary' => true]);

        $this->install->name = 'domain';
        $this->install->save();
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
