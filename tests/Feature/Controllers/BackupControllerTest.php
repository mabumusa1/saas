<?php

namespace Tests\Feature\Controllers;

use App\Events\CreateBackupEvent;
use App\Events\RestoreBackupEvent;
use App\Models\Account;
use App\Models\Backup;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Mockery;
use Spatie\Dns\Records\TXT;
use Tests\TestCase;

class BackupControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
        parent::addBackup();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_backups_index()
    {
        $this->get(route('backups.index', [$this->account, $this->site, $this->install]))
        ->assertOk()
        ->assertViewIs('installs.backups.index');
    }

    public function test_backups_store_success()
    {
        Event::fake();
        $this->post(route('backups.store', [$this->account, $this->site, $this->install]), ['description' => 'sometest'])
        ->assertRedirect();

        $this->assertDatabaseHas('backups', [
            'description' => 'sometest',
        ]);
        Event::assertDispatched(CreateBackupEvent::class);
    }

    public function test_backups_restore_success()
    {
        Event::fake();

        $this->post(route('backups.restore', [$this->account, $this->site, $this->install, $this->backup]))
        ->assertRedirect();

        Event::assertDispatched(RestoreBackupEvent::class);
    }
}
