<?php

namespace Tests\Feature\Models;

use App\Events\AccountUpdatedEvent;
use App\Jobs\SyncStripe;
use App\Listeners\AccountUpdatedListener;
use App\Models\Account;
use App\Models\Invite;
use App\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_account_datacenter()
    {
        $account = Account::factory()->create();
        $this->assertEquals(1, $account->dataCenter->id);
    }

    public function test_account_without_stripe_id_updated()
    {
        Event::fake([
            AccountUpdatedEvent::class,
        ]);
        $account = Account::factory()->create();
        $account->name = 'Test';
        $account->save();
        Event::assertDispatched(AccountUpdatedEvent::class);

        \Bus::fake();
        $listener = new AccountUpdatedListener();
        $listener->handle(new AccountUpdatedEvent($account));
        \Bus::assertDispatched(SyncStripe::class);
    }

    public function test_stripe_public_properties()
    {
        $account = Account::factory()->create();
        $account->name = 'Test';
        $account->save();

        $this->assertEquals($account->name, $account->stripeName());
        $this->assertEquals($account->email, $account->stripeEmail());
    }

    public function test_invites()
    {
        $account = Account::factory()->create();
        $invite = Invite::factory()->create(['account_id' => $account->id]);

        $this->assertEquals($account->invites->count(), 1);
    }
}
