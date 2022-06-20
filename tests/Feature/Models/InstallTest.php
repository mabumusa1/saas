<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Backup;
use App\Models\Cashier\Subscription;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Site;
use App\Models\Transfer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstallTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
    }

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_contact_install():void
    {
        $this->assertEquals($this->contact->install->contact->id, $this->contact->id);
    }

    public function test_transfer_install():void
    {
        $transfer = Transfer::factory()->create([
            'install_id' => $this->install->id,
            'code' => 'somecode',
        ]);
        $this->assertEquals($this->install->transfer->id, $transfer->id);
    }

    public function test_backup_install():void
    {
        $this->addBackup();
        $this->assertEquals($this->install->backups->first()->id, $this->backup->id);
    }

    public function test_size_install():void
    {
        $this->assertEquals($this->install->size, 's0');
    }

    public function test_size_install_with_subscription():void
    {
        $this->subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
            'name' => 's1',
        ]);

        $this->site->subscription_id = $this->subscription->id;
        $this->site->save();
        $this->assertEquals($this->install->size, 's1');
    }
}
