<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Cashier\Subscription;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StripeEventListenerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->create([
            'name' => 'test',
            'email' => 'test@a.com',
            'stripe_id' => 'cus_LLPXDw7ATzNcRX',
        ]);
        $this->user = User::factory()->create();
        $this->plan = Plan::first();
        $this->account->users()->attach($this->user->id, ['role' => 'owner']);

        $this->actingAs($this->user);
        $this->subscription = new Subscription();
        $this->subscription->account_id = $this->account->id;
        $this->subscription->name = $this->plan->name;
        $this->subscription->stripe_id = 'sub_1KeidZJJANQIX4AvkeasYUuG';
        $this->subscription->stripe_status = 'test';
        $this->subscription->stripe_price = 'test';
        $this->subscription->quantity = 1;
        $this->subscription->trial_ends_at = null;
        $this->subscription->ends_at = now();
        $this->subscription->save();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_delete_subscription()
    {
        $json = '{"id":"evt_1KfRT5JJANQIX4Avwymy2qON","object":"event","api_version":"2020-08-27","created":1647793139,"data":{"object":{"id":"sub_1KeidZJJANQIX4AvkeasYUuG","object":"subscription","application_fee_percent":null,"automatic_tax":{"enabled":false},"billing_cycle_anchor":1647793136,"billing_thresholds":null,"cancel_at":null,"cancel_at_period_end":false,"canceled_at":1647793139,"collection_method":"charge_automatically","created":1647793136,"current_period_end":1650471536,"current_period_start":1647793136,"customer":"cus_LM9mPZNLT6Omfx","days_until_due":null,"default_payment_method":null,"default_source":null,"default_tax_rates":[],"discount":null,"ended_at":1647793139,"items":{"object":"list","data":[{"id":"si_LM9mF88MKldAUH","object":"subscription_item","billing_thresholds":null,"created":1647793136,"metadata":{},"plan":{"id":"plan_LM9mf9qGWg6UUV","object":"plan","active":true,"aggregate_usage":null,"amount":2000,"amount_decimal":"2000","billing_scheme":"per_unit","created":1647793134,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{},"nickname":null,"product":"prod_LM9mDQbn7P5oMb","tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"price":{"id":"plan_LM9mf9qGWg6UUV","object":"price","active":true,"billing_scheme":"per_unit","created":1647793134,"currency":"usd","livemode":false,"lookup_key":null,"metadata":{},"nickname":null,"product":"prod_LM9mDQbn7P5oMb","recurring":{"aggregate_usage":null,"interval":"month","interval_count":1,"trial_period_days":null,"usage_type":"licensed"},"tax_behavior":"unspecified","tiers_mode":null,"transform_quantity":null,"type":"recurring","unit_amount":2000,"unit_amount_decimal":"2000"},"quantity":1,"subscription":"sub_1KfRT2JJANQIX4AvHQ6KTYO1","tax_rates":[]}],"has_more":false,"total_count":1,"url":"/v1/subscription_items?subscription=sub_1KfRT2JJANQIX4AvHQ6KTYO1"},"latest_invoice":"in_1KfRT2JJANQIX4AvkcpQg3df","livemode":false,"metadata":{},"next_pending_invoice_item_invoice":null,"pause_collection":null,"payment_settings":{"payment_method_options":null,"payment_method_types":null},"pending_invoice_item_interval":null,"pending_setup_intent":null,"pending_update":null,"plan":{"id":"plan_LM9mf9qGWg6UUV","object":"plan","active":true,"aggregate_usage":null,"amount":2000,"amount_decimal":"2000","billing_scheme":"per_unit","created":1647793134,"currency":"usd","interval":"month","interval_count":1,"livemode":false,"metadata":{},"nickname":null,"product":"prod_LM9mDQbn7P5oMb","tiers_mode":null,"transform_usage":null,"trial_period_days":null,"usage_type":"licensed"},"quantity":1,"schedule":null,"start_date":1647793136,"status":"canceled","test_clock":null,"transfer_data":null,"trial_end":null,"trial_start":null}},"livemode":false,"pending_webhooks":2,"request":{"id":"req_aZhZOnoqAxpLVD","idempotency_key":null},"type":"customer.subscription.deleted"}';

        $response = $this->postJson('stripe/webhook', json_decode($json, true));

        $response->assertStatus(200);
    }
}
