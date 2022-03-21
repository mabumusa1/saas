<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Cashier\Subscription;
use App\Models\Plan;
use App\Models\User;
use GuzzleHttp\ClientInterface;
use Http;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Str;
use Stripe\ApiRequestor;
use Tests\TestCase;

class BillingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockStripe();
        $this->account = Account::factory()->create([
            'name' => 'test',
            'email' => 'test@a.com',
            'stripe_id' => 'cus_LLPXDw7ATzNcRX',
        ]);
        $this->user = User::factory()->create();
        $this->plan = Plan::first();
        $this->account->users()->attach($this->user->id, ['role' => 'owner']);
        $this->account->createOrGetStripeCustomer(['name' => $this->account->name, 'email' => $this->account->email]);
        $this->paymentMethod = $this->account->defaultPaymentMethod();
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
    public function test_index_displays_view()
    {
        $this->account->updateDefaultPaymentMethod($this->paymentMethod->id);
        $response = $this->get(route('billing.index', $this->account));
        $response->assertStatus(200);
        $response->assertViewIs('billing.index');
    }

    public function test_index_displays_view_without_payment_method()
    {
        $this->account->deletePaymentMethods();
        $response = $this->get(route('billing.index', $this->account).'?update');

        $response->assertStatus(200);
        $response->assertViewIs('billing.index');
        $response->assertViewHas('intent');
    }

    public function test_store_fails_without_payment_method()
    {
        $response = $this->put(route('billing.update', $this->account));

        $response->assertStatus(403);
    }

    public function test_store_success()
    {
        $response = $this->put(route('billing.update', $this->account), [
            'payment_method' => 'pm_card_visa',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => __('Saved Card Information')]);
    }

    public function test_update_success()
    {
        $response = $this->put(route('billing.info.update', $this->account), [
            'name' => 'test',
            'email' => 'test@a.com',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function test_manage_subscriptions()
    {
        $response = $this->get(route('billing.manageSubscriptions', $this->account));

        $response->assertStatus(200);
        $response->assertViewIs('billing.manageSubscriptions');
    }

    public function test_subscribe_with_monthly_subscription()
    {
        $this->account->updateDefaultPaymentMethod($this->paymentMethod->id);
        $response = $this->post(route('billing.subscribe', ['account' => $this->account, 'plan' => $this->plan]), [
            'period' => 'month',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('sites.index', $this->account));
    }

    public function test_subscribe_with_yearly_subscription()
    {
        $this->account->updateDefaultPaymentMethod($this->paymentMethod->id);
        $response = $this->post(route('billing.subscribe', ['account' => $this->account, 'plan' => $this->plan]), [
            'period' => 'year',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('sites.index', $this->account));
    }

    public function test_invoice_returns_404_with_wrong_invoice()
    {
        $response = $this->get(route('billing.invoice', ['account' => $this->account, 'invoice' => 1]));

        $response->assertStatus(404);
    }

    public function test_invoice_success()
    {
        $invoice = $this->account->invoices()->first();
        $response = $this->get(route('billing.invoice', ['account' => $this->account, 'invoice' => $invoice->id]));

        $response->assertStatus(200);
    }
}
