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

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
    }

    public function test_install_transfer():void
    {
        $transfer = Transfer::factory()->create([
            'install_id' => $this->install->id,
            'code' => 'somecode',
        ]);

        $this->assertEquals($transfer->install->id, $this->install->id);
    }
}
