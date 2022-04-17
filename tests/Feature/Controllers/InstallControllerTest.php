<?php

namespace Tests\Feature\Controllers;

use App\Events\InstallCopyEvent;
use App\Events\InstallDestroy;
use App\Events\SiteLockEvent;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class InstallControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_displays_view()
    {
        $this->get(route('installs.show', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
            ->assertOk()
            ->assertViewIs('installs.show');
    }

    public function test_create_all_types_used()
    {
        $site = Site::factory()->for($this->account)->create();
        $install = Install::factory()
        ->count(3)
        ->for($site)
        ->state(new Sequence(
            ['type' => 'prd'],
            ['type' => 'stg'],
            ['type' => 'dev']
        ))
        ->create();

        $response = $this->get(route('installs.create', ['account' => $this->account, 'site' => $site, 'install' => $install]));
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_create_displays_view_specific_env()
    {
        $site = Site::factory()->for($this->account)->create();
        $install = Install::factory()
        ->for($site)
        ->create(['type' => 'stg']);
        $this->get(route('installs.create', ['account' => $this->account, 'site' => $site, 'env' => 'dev']))
            ->assertOk()
            ->assertViewIs('installs.create')
            ->assertViewHas('selectedEnv', 'dev');
    }

    public function test_create_displays_view()
    {
        $site = Site::factory()->for($this->account)->create();
        $install = Install::factory()
        ->for($site)
        ->create();
        $this->get(route('installs.create', ['account' => $this->account, 'site' => $site]))
            ->assertOk()
            ->assertViewIs('installs.create');
    }

    public function test_store_fails_if_type_is_wrong()
    {
        $site = Site::factory()->for($this->account)->create();
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'type' => 'dev',
        ]);
        $response->assertSessionHasErrors('type');
    }

    public function test_store_fails_if_wrong_url()
    {
        $site = Site::factory()->for($this->account)->create();
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'type' => 'dev',
            'name' => '[]',
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function test_store_validation()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'name' => 'test',
            'isValidation' => true,
        ]);
        $response->assertJson(['valid' => true]);
    }

    public function test_store_same_type()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'name' => 'test',
            'type' => 'dev',
        ]);
        $response->assertSessionHasErrors(['type']);
    }

    public function test_store_success()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'name' => 'test',
            'type' => 'prd',
        ]);
        $response->assertSessionHasNoErrors();
    }

    public function test_copy_success()
    {
        Event::fake();
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $dest = Install::factory()
        ->for($site)
        ->create([
            'type' => 'prd',
        ]);

        $response = $this->put(route('installs.copy', ['account' => $this->account, 'site' => $site, 'install' => $install]), [
            'destination' => $dest->id,

        ]);

        Event::assertDispatched(InstallCopyEvent::class);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_lock_success()
    {
        Event::fake();
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);

        $response = $this->post(route('installs.lock', ['account' => $this->account, 'site' => $site, 'install' => $install]));

        $response->assertRedirect();

        Event::assertDispatched(SiteLockEvent::class);
    }

    public function test_destroy_install_fail()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create();

        $response = $this->delete(route('installs.destroy', ['account' => $this->account, 'site' => $site, 'install' => $install]));
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_destroy_install()
    {
        Event::fake();
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install1 = Install::factory()
        ->for($site)
        ->create();

        $install2 = Install::factory()
        ->for($site)
        ->create();

        $response = $this->delete(route('installs.destroy', ['account' => $this->account, 'site' => $site, 'install' => $install1]));
        Event::assertDispatched(function (InstallDestroy $event) use ($install1) {
            return $event->install->id === $install1->id;
        });
        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertSoftDeleted($install1);
    }

    /***
     * Methods that show views at the moment, they should be
     * removed to other controllers
     */

    public function test_views_install()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);

        $response = $this->get(route('installs.cdn', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.cdn.index');

        $response = $this->get(route('installs.redirectRules', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.redirect-rules.index');

        $response = $this->get(route('installs.backupPoints', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.backup-points.index');

        $response = $this->get(route('installs.accessLogs', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.logs.access');

        $response = $this->get(route('installs.errorLogs', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.logs.error');

        $response = $this->get(route('installs.utilities', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.utilities.index');

        $response = $this->get(route('installs.caching', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.caching.index');

        $response = $this->get(route('installs.migration', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.migration.index');

        $response = $this->get(route('installs.liveCheck', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.live-checklist.index');

        $response = $this->get(route('installs.webRules', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.web-rules.index');

        $response = $this->get(route('installs.cron', ['account' => $this->account, 'site' => $site, 'install' => $install]))
        ->assertViewIs('installs.cron.index');
    }
}
