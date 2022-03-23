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
use Laravel\Cashier\Cashier;
use Mockery;
use Str;
use Stripe\ApiRequestor;
use Tests\TestCase;
use Laravel\Cashier\PaymentMethod;

class BillingControllerTest extends TestCase
{
    use RefreshDatabase;

    private Account $account;
    private User $user;
    private Plan $plan;
    private $paymentMethod;

    public function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->create([
            'name' => 'Test Account',
            'email' => 'test@domain.com'
        ]);
        $this->user = User::factory()->create();
        $this->plan = Plan::first();
        $this->account->users()->attach($this->user->id, ['role' => 'owner']);
        $this->actingAs($this->user);

        $this->paymentMethod = Cashier::stripe()->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => '5555555555554444',
                'exp_month' => 3,
                'exp_year' => 2023,
                'cvc' => '314',
            ],
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_displays_view_without_default_payment()
    {
        $response = $this->get(route('billing.index', $this->account));
        $response->assertStatus(200);
        $response->assertViewIs('billing.index');
    }

    public function test_index_displays_view_with_default_payment()
    {  
        $x = $this->account->createOrGetStripeCustomer([
            'name' => 'Test Account',
            'email' => 'test@domain.com'
        ]);        
        
        $this->account->addPaymentMethod($this->paymentMethod->id);
        $this->account->updateDefaultPaymentMethod($this->paymentMethod->id);
        
        $response = $this->get(route('billing.index', $this->account));
        $response->assertStatus(200);
        $response->assertViewIs('billing.index');
        $response->assertViewMissing('intent');
        
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
            'payment_method' => $this->account->defaultPaymentMethod()->id,
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
        $response = $this->post(route('billing.subscribe', ['account' => $this->account, 'plan' => $this->plan]), [
            'period' => 'month',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('sites.index', $this->account));
    }

    public function test_subscribe_with_yearly_subscription()
    {
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
