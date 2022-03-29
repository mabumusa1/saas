<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\Cashier\Subscription;
use App\Models\Install;
use App\Models\Site;
use App\Models\Transfer;
use App\Models\User;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Str;
use Tests\TestCase;

class TransferControllerTest extends TestCase
{
    use RefreshDatabase;

    private $site;

    private $subscription;

    private $install;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
        $this->subscription = Subscription::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $this->site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);

        $this->install = Install::factory()->create([
            'site_id' => $this->site->id,
        ]);
    }

    public function test_start_transfer()
    {
        $response = $this->post(route('transfer.start', [$this->account->id, $this->install->id]), [
            'email' => 'someemail@domain.com',
            'note' => 'some note',
        ]);
        $response->assertRedirect();
    }

    public function test_accept_transfer()
    {
        $code = Str::random(16);
        $transfer = Transfer::factory()->create([
            'account_id' => $this->account->id,
            'install_id' => $this->install->id,
            'code' => $code,
        ]);
        $response = $this->post(route('transfer.accept', [$this->account->id]), [
            'code' => $code,
        ]);
        $response->assertRedirect();
    }

    public function test_accept_transfer_code_not_found()
    {
        $code = Str::random(16);
        $transfer = Transfer::factory()->create([
            'account_id' => $this->account->id,
            'install_id' => $this->install->id,
            'code' => 'somecode',
        ]);
        $response = $this->post(route('transfer.accept', [$this->account->id]), [
            'code' => $code,
        ]);
        $response->assertRedirect();
    }
}
