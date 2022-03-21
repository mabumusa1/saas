<?php

namespace Tests\Feature;

use App\Events\AccountUpdatedEvent;
use App\Jobs\SyncStripe;
use App\Listeners\AccountUpdatedListener;
use App\Models\Account;
use App\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Tests\TestCase;

class ModelsTest extends TestCase
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
        $account->name = 'ss';
        $account->save();
        Event::assertDispatched(AccountUpdatedEvent::class);

        \Bus::fake();
        $listener = new AccountUpdatedListener();
        $listener->handle(new AccountUpdatedEvent($account));
        \Bus::assertDispatched(SyncStripe::class);
    }

    public function test_account_with_stripe()
    {
        $account = Account::factory()->create(['stripe_id' => 'test']);
        $spy = $this->spy(Account::class);
        $listener = new AccountUpdatedListener();
        $listener->handle(new AccountUpdatedEvent($account));
        $spy->shouldHaveReceived('hasStripeId');
        $spy->shouldNotHaveReceived('syncStripeCustomerDetails');
    }
}
