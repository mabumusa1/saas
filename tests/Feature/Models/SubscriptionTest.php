<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Activity;
use App\Models\Cashier\Subscription;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    private Plan $plan;

    public function setUp():void
    {
        parent::setUp();
        $this->plan = new Plan([
            'name' => 's1',
            'display_name' => 'Small - 2,500 Leads',
            'short_description' => 'Small Mautic installation supports up to 2,500 leads',
            'stripe_product_id' => 'prod_LF6rlbuqYaz6k1',
            'stripe_monthly_price_id' => 'price_1KYcdZJJANQIX4AvM2ySzZzb',
            'stripe_yearly_price_id' => 'price_1KYcdZJJANQIX4AvZvUiYVZz',
            'monthly_price' => 50,
            'yearly_price' => 500,
            'features' => ['2,500 Contacts', 'Backups', 'Hosting', 'Security', 'Scalablity'],
            'contacts' => 2500,
            'options' => ['backups', 'hosting'],
            'archived' => false,
            'available' => true,
        ]);
        $this->account = Account::factory()->create();
    }

    /**
     * @dataProvider planProvider
     * check account with datacenter.
     *
     * @return void
     */
    public function test_subscription_period(string $expectedOutput, string $input):void
    {
        $subscription = new Subscription();
        $subscription->account_id = $this->account->id;
        $subscription->name = $this->plan->name;
        $subscription->stripe_id = 'sub_1KeidZJJANQIX4AvkeasYUuG';
        $subscription->stripe_status = 'test';
        $subscription->stripe_price = $input;
        $subscription->quantity = 1;
        $subscription->trial_ends_at = null;
        $subscription->ends_at = now();
        $subscription->save();
        $this->assertEquals($subscription->period, $expectedOutput);
    }

    public function test_subscription_wrong_period():void
    {
        $subscription = new Subscription();
        $subscription->account_id = $this->account->id;
        $subscription->name = $this->plan->name;
        $subscription->stripe_id = 'sub_1KeidZJJANQIX4AvkeasYUuG';
        $subscription->stripe_status = 'test';
        $subscription->stripe_price = 'wrong';
        $subscription->quantity = 1;
        $subscription->trial_ends_at = null;
        $subscription->ends_at = now();
        $subscription->save();
        $this->assertNull($subscription->period);
    }

    public function test_subscription_displayName()
    {
        $subscription = new Subscription();
        $subscription->account_id = $this->account->id;
        $subscription->name = $this->plan->name;
        $subscription->stripe_id = 'sub_1KeidZJJANQIX4AvkeasYUuG';
        $subscription->stripe_status = 'test';
        $subscription->stripe_price = 'test';
        $subscription->quantity = 1;
        $subscription->trial_ends_at = null;
        $subscription->ends_at = now();
        $subscription->save();
        $this->assertEquals($subscription->displayName, $this->plan->display_name);
    }

    /**
     * @return string[][]
     */
    public function planProvider(): array
    {
        return [
            [
                'monthly',
                'price_1KYcdZJJANQIX4AvM2ySzZzb',

            ],
            [
                'yearly',
                'price_1KYcdZJJANQIX4AvZvUiYVZz',
            ],
        ];
    }
}
