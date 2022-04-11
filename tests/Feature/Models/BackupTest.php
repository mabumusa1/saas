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

    public function test_install_backup():void
    {
        $account = Account::factory()->create();
        $site = Site::factory()->create(['account_id' => $account->id]);
        $install = Install::factory()->create(['site_id' => $site->id]);
        $backup = Backup::factory()->create([
            'install_id' => $install->id,
        ]);
        $this->assertEquals($backup->install->id, $install->id);
    }
}
