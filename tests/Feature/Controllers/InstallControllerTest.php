<?php

namespace Tests\Feature\Controllers;

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
        $this->site->installs()->delete();
        Install::withoutEvents(function () {
            Install::factory()
            ->count(3)
            ->for($this->site)
            ->state(new Sequence(
                ['type' => 'prd'],
                ['type' => 'stg'],
                ['type' => 'dev']
            ))
            ->create();
        });

        $response = $this->get(route('installs.create', ['account' => $this->account, 'site' => $this->site]));
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_create_displays_view_specific_env()
    {
        $this->get(route('installs.create', ['account' => $this->account, 'site' => $this->site, 'env' => 'stg']))
        ->assertOk()
        ->assertViewIs('installs.create')
        ->assertViewHas('selectedEnv', 'stg');
    }

    public function test_create_displays_view()
    {
        $this->get(route('installs.create', ['account' => $this->account, 'site' => $this->site]))
            ->assertOk()
            ->assertViewIs('installs.create');
    }

    public function test_store_fails_if_type_is_wrong()
    {
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $this->site]), [
            'type' => 'dev',
        ]);
        $response->assertSessionHasErrors('type');
    }

    public function test_store_fails_if_wrong_url()
    {
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $this->site]), [
            'type' => 'dev',
            'name' => '[]',
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function test_store_validation()
    {
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $this->site]), [
            'name' => 'test',
            'isValidation' => true,
        ]);
        $response->assertJson(['valid' => true]);
    }

    public function test_store_same_type()
    {
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $this->site]), [
            'name' => 'test',
            'type' => 'dev',
        ]);
        $response->assertSessionHasErrors(['type']);
    }

    public function test_store_success()
    {
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $this->site]), [
            'name' => 'test',
            'type' => 'prd',
        ]);
        $response->assertSessionHasNoErrors();
    }

    public function test_copy_success()
    {
        Event::fake();

        $dest = Install::withoutEvents(function () {
            return Install::factory()
            ->for($this->site)
            ->create([
                'type' => 'prd',
            ]);
        });

        $response = $this->put(route('installs.copy', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]), [
            'destination' => $dest->id,

        ]);

        Event::assertDispatched('eloquent.copied: App\Models\Install');

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_lock_success()
    {
        Event::fake();

        $response = $this->post(route('installs.lock', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]));

        $response->assertRedirect();

        Event::assertDispatched('eloquent.locked: App\Models\Install');
    }

    public function test_destroy_install_fail()
    {
        $response = $this->delete(route('installs.destroy', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]));
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_destroy_install()
    {
        Install::withoutEvents(function () {
            $anotherInstall = Install::factory()
            ->for($this->site)
            ->create();

            $response = $this->delete(route('installs.destroy', ['account' => $this->account, 'site' => $this->site, 'install' => $anotherInstall]));
            $response->assertRedirect();
            $response->assertSessionHas('success');
            $this->assertSoftDeleted($anotherInstall);
        });
    }

    /***
     * Methods that show views at the moment, they should be
     * removed to other controllers
     */

    public function test_views_install()
    {
        $response = $this->get(route('installs.cdn', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.cdn.index');

        $response = $this->get(route('installs.redirectRules', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.redirect-rules.index');

        $response = $this->get(route('installs.backupPoints', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.backup-points.index');

        $response = $this->get(route('installs.accessLogs', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.logs.access');

        $response = $this->get(route('installs.errorLogs', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.logs.error');

        $response = $this->get(route('installs.utilities', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.utilities.index');

        $response = $this->get(route('installs.caching', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.caching.index');

        $response = $this->get(route('installs.migration', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.migration.index');

        $response = $this->get(route('installs.liveCheck', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.live-checklist.index');

        $response = $this->get(route('installs.webRules', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.web-rules.index');

        $response = $this->get(route('installs.cron', ['account' => $this->account, 'site' => $this->site, 'install' => $this->install]))
        ->assertViewIs('installs.cron.index');
    }
}
