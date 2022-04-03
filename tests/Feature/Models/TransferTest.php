<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Site;
use App\Models\Transfer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_install_transfer():void
    {
        $account = Account::factory()->create();
        $site = Site::factory()->create(['account_id' => $account->id]);
        $install = Install::factory()->create(['site_id' => $site->id]);
        $transfer = Transfer::factory()->create([
            'account_id' => $account->id,
            'install_id' => $install->id,
            'code' => 'somecode',
        ]);

        $this->assertEquals($transfer->install->id, $install->id);
    }
}
