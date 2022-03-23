<?php

namespace Tests;

use App\Models\Account;
use App\Models\Cashier\Subscription;
use App\Models\Plan;
use Event;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Cashier\Subscription as CashierSubscription;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createMockedSubscription(Account $account, Plan $plan, $data = []): CashierSubscription
    {
        $sub = null;
        Event::fakeFor(function () use ($account, $plan, $data, &$sub) {
            $sub = Subscription::factory()->create(array_merge([
                'account_id' => $account->id,
                'name' => $plan->name,
                'stripe_status' => \Stripe\Subscription::STATUS_ACTIVE,
                'stripe_price' => $plan->stripe_plan_id,
                'quantity' => 1,
                'trial_ends_at' => null,
                'ends_at' => null,
            ], $data));
        });
        // by default active subscription
        return $sub;
    }
}
