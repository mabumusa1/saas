<?php

namespace Tests\Feature\Jobs;

use App\Jobs\SyncStripe;
use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SyncStripeTest extends TestCase
{
    use RefreshDatabase;

    public function test_account_with_stripe()
    {
        $account = Account::factory()->create(['stripe_id' => 'test']);
        $accountMock = \Mockery::mock($account);
        $accountMock->shouldReceive('hasStripeId')
        ->andReturn(true);
        $accountMock->shouldReceive('syncStripeCustomerDetails')
        ->once();
        $job = new SyncStripe($accountMock);
        $job->handle($accountMock);
    }
}
