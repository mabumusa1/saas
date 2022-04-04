<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\Cashier\Subscription;
use App\Models\Install;
use App\Models\Site;
use App\Models\Transfer;
use App\Models\User;
use App\Notifications\TransferRequestNotification;
use Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
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
        Notification::fake();
        $response = $this->post(route('transfer.start', [$this->account->id, $this->site->id, $this->install->id]), [
            'email' => 'someemail@domain.com',
            'note' => 'some note',
        ]);

        $this->assertDatabaseCount('transfers', 1);

        Notification::assertSentTo(
            new AnonymousNotifiable,
            TransferRequestNotification::class,
            function ($notification, $channels, $notifiable) {
                $mailData = $notification->toMail()->toArray();
                $this->assertEquals('Someone sent you a shiny, new environment!', $mailData['greeting']);
                $this->assertEquals('Here\'s your code to pick it up', $mailData['introLines'][0]);

                return $notifiable->routes['mail'] === 'someemail@domain.com';
            }
        );
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    public function test_accept_transfer_code_found()
    {
        $code = Str::random(16);
        $transfer = Transfer::factory()->create([
            'install_id' => $this->install->id,
            'code' => $code,
        ]);
        $response = $this->post(route('transfer.check', [$this->account->id]), [
            'code' => $code,
        ]);
        $response->assertSessionHas('code', $code);
        $response->assertRedirect(route('transfer.show', [$this->account, $transfer]));
    }

    public function test_accept_transfer_code_not_found()
    {
        $code = Str::random(16);
        $transfer = Transfer::factory()->create([
            'install_id' => $this->install->id,
            'code' => $code,
        ]);
        $response = $this->post(route('transfer.check', [$this->account->id]), [
            'code' => 'sssss',
        ]);

        $response->assertSessionHasErrors('code');
    }

    public function test_show_transfer()
    {
        $code = Str::random(16);
        $transfer = Transfer::factory()->create([
            'install_id' => $this->install->id,
            'code' => $code,
        ]);

        $response = $this->actingAs($this->user)->withSession(['code' => $code])->get(route('transfer.show', [$this->account->id, $transfer]));
        $response->assertViewIs('transfers.show')->assertOk();
    }

    public function test_show_transfer_without_code()
    {
        $code = Str::random(16);
        $transfer = Transfer::factory()->create([
            'install_id' => $this->install->id,
            'code' => $code,
        ]);

        $response = $this->actingAs($this->user)->get(route('transfer.show', [$this->account->id, $transfer]));
        $response->assertForbidden();
    }

    public function test_accept_transfer_to_new_site()
    {
        $code = Str::random(16);
        $transfer = Transfer::factory()->create([
            'install_id' => $this->install->id,
            'code' => $code,
        ]);

        $response = $this->post(route('transfer.accept', [$this->account->id, $transfer]), [
            'transfer_way' => 'new',
            'site_name' => 'new site',
        ]);

        $response->assertRedirect(route('installs.show', ['account' => $this->account, 'site' => ++$this->install->site->id, 'install' => $this->install]));

        $this->assertDatabaseHas('sites', ['name' => 'new site']);
        $this->assertDatabaseMissing('transfers', ['id' => $transfer->id]);
    }

    public function test_accept_transfer_to_existing_site()
    {
        $code = Str::random(16);
        $transfer = Transfer::factory()->create([
            'install_id' => $this->install->id,
            'code' => $code,
        ]);

        $account = Account::factory()->create();
        $user = User::factory()->create();
        $account->users()->attach($user->id, ['role' => 'owner']);
        $site = Site::factory()->create([
            'account_id' => $account->id,
        ]);
        $this->actingAs($user);

        $response = $this->post(route('transfer.accept', [$account, $transfer]), [
            'transfer_way' => 'existing',
            'site_id' => $site->id,
        ]);

        $response->assertRedirect(route('installs.show', ['account' => $account->id, 'site' => $site->id, 'install' => $this->install]));

        $this->assertDatabaseHas('installs', ['site_id' => $site->id]);
        $this->assertDatabaseMissing('transfers', ['id' => $transfer->id]);
    }
}
