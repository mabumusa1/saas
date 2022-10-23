<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Plan;
use App\Models\Subscription;
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
        $this->plan->save();

        parent::addAccount();
        parent::addSite();

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

        $this->account->createOrGetStripeCustomer();

        $this->account->addPaymentMethod($this->paymentMethod);
        $this->account->updateDefaultPaymentMethod($this->paymentMethod);
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
        $this->subscription = Subscription::factory()->create([
            'name' => 's1',
        ]);

        $this->site->subscription_id = $this->subscription->id;
        $this->site->save();
        $this->subscription->site_id = $this->site->id;
        $this->subscription->save();

        $response = $this->get(route('billing.manageSubscriptions', $this->account));
        $response->assertStatus(200);
        $response->assertViewIs('billing.manageSubscriptions');
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
