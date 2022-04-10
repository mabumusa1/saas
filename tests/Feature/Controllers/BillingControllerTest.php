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
use Laravel\Cashier\PaymentMethod;
use Laravel\Cashier\SubscriptionBuilder;
use Mockery;
use Str;
use Stripe\ApiRequestor;
use Tests\TestCase;

class BillingControllerTest extends TestCase
{
    use RefreshDatabase;

    private Plan $plan;

    private $paymentMethod;

    private $stripeProduct;

    private $stripeInvoice;

    public function setUp():void
    {
        parent::setUp();

        /**
         * Clear the Mock Server first before any test.
         */
        $response = Http::delete(config('services.stripe.api_base').'/_config/data');
        if ($response->status() !== 200) {
            $this->fail('Could not mock stripe local');
        }

        $this->paymentMethod = Cashier::stripe()->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 3,
                'exp_year' => 2050,
                'cvc' => '314',
            ],
        ]);
        $this->stripeProduct = Cashier::stripe()->products->create([
            'id' => 'prod_LF6rlbuqYaz6k1',
            'name' => 'Small - 2500 Leads',
            'description' => 'Small Mautic installation supports up to 2500 leads',
            'type' =>  'service',

        ]);

        $this->account = Account::factory()->create([
            'name' => 'Test Account',
            'email' => 'test@domain.com',
        ]);
        $this->user = User::factory()->create();
        $this->plan = Plan::first();

        $this->account->users()->attach($this->user->id, ['role' => 'owner']);
        $this->account->createOrGetStripeCustomer();

        $this->account->addPaymentMethod($this->paymentMethod);
        $this->account->updateDefaultPaymentMethod($this->paymentMethod);

        $this->actingAs($this->user);
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
            'email' => 'test@domain.com',
        ]);

        $this->account->updateDefaultPaymentMethod($this->paymentMethod->id);

        $response = $this->get(route('billing.index', $this->account));
        $response->assertStatus(200);
        $response->assertViewIs('billing.index');
        $response->assertViewMissing('intent');
    }

    public function test_index_displays_view_without_payment_method()
    {
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
        /**
         * This test is using Mock because localstripe does not support prices
         * Once it support prices this test should be changed.
         */
        $builderMock = \Mockery::mock(SubscriptionBuilder::class);
        $builderMock->shouldReceive('create')->andReturn(true);

        $accountMock = \Mockery::mock($this->account);
        $accountMock->shouldReceive('newSubscription')
        ->andReturn($builderMock);

        $request = \Request::create(route('billing.subscribe', ['account' => $accountMock, 'plan' => $this->plan]), 'POST', [
            'period' => 'month',
        ]);

        $controller = new \App\Http\Controllers\BillingController();
        $response = $controller->subscribe($accountMock, $this->plan, $request);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_subscribe_with_yearly_subscription()
    {

        /**
         * This test is using Mock because localstripe does not support prices
         * Once it support prices this test should be changed.
         */
        $builderMock = \Mockery::mock(SubscriptionBuilder::class);
        $builderMock->shouldReceive('create')->andReturn(true);

        $accountMock = \Mockery::mock($this->account);
        $accountMock->shouldReceive('newSubscription')
        ->andReturn($builderMock);

        $request = \Request::create(route('billing.subscribe', ['account' => $accountMock, 'plan' => $this->plan]), 'POST', [
            'period' => 'year',
        ]);

        $controller = new \App\Http\Controllers\BillingController();
        $response = $controller->subscribe($accountMock, $this->plan, $request);
        $this->assertEquals(302, $response->getStatusCode());
    }

    public function test_invoice_returns_404_with_wrong_invoice()
    {
        $response = $this->get(route('billing.invoice', ['account' => $this->account, 'invoice' => 1]));

        $response->assertStatus(404);
    }

    public function test_invoice_success()
    {
        $accountMock = \Mockery::mock($this->account);
        $accountMock->shouldReceive('downloadInvoice')
           ->andReturn(\Response([], 200, [
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename=file.pdf"',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Type' => 'application/pdf',
            'X-Vapor-Base64-Encode' => 'True',
        ]));

        $controller = new \App\Http\Controllers\BillingController();
        $response = $controller->invoice($accountMock, 1);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
