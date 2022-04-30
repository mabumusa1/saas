<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Backup;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Site;
use App\Models\Transfer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BackupTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
        parent::addBackup();
    }

    public function test_install_backup():void
    {
        $this->assertEquals($this->backup->install->id, $this->install->id);
    }
}
