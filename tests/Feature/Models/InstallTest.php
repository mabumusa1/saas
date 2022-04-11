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

class InstallTest extends TestCase
{
    use RefreshDatabase;

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_contact_install():void
    {
        $account = Account::factory()->create();
        $site = Site::factory()->create(['account_id' => $account->id]);
        $install = Install::factory()->create(['site_id' => $site->id]);
        $contact = Contact::factory()->create(['install_id' => $install->id]);
        $this->assertEquals($contact->install->contact->id, $contact->id);
    }

    public function test_transfer_install():void
    {
        $account = Account::factory()->create();
        $site = Site::factory()->create(['account_id' => $account->id]);
        $install = Install::factory()->create(['site_id' => $site->id]);
        $transfer = Transfer::factory()->create([
            'install_id' => $install->id,
            'code' => 'somecode',
        ]);
        $this->assertEquals($install->transfer->id, $transfer->id);
    }

    public function test_backup_install():void
    {
        $account = Account::factory()->create();
        $site = Site::factory()->create(['account_id' => $account->id]);
        $install = Install::factory()->create(['site_id' => $site->id]);
        $backup = Backup::factory()->create([
            'install_id' => $install->id,
        ]);
        $this->assertEquals($install->backups->first()->id, $backup->id);
    }
}
