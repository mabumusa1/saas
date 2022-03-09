<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutLinkRequest;
use App\Http\Requests\makePayLinkRequest;
use App\Models\Account;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Account $account)
    {
        if ($account->hasDefaultPaymentMethod()) {
            return view('billing.index');
        } else {
            return view('billing.index', ['intent' => $account->createSetupIntent()]);
        }
    }

    public function store(Account $account, Request $request)
    {
        if ($request->has('payment_method')) {
            $stripeCustomer = $account->createOrGetStripeCustomer(['name' => $account->name, 'email' => $account->email]);
            $paymentMethod = $request->input('payment_method');
            $account->addPaymentMethod($paymentMethod);
            $account->updateDefaultPaymentMethod($paymentMethod);
            $account->updateDefaultPaymentMethodFromStripe();

            return response()->json(['message' => __('Saved Card Information')], 200);
        } else {
            abort(403);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function checkout(Account $account)
    {
        $plans = Plan::all();

        return view('payment.checkout', ['plans' => $plans]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function makeCheckoutLink(Account $account, CheckoutLinkRequest $request)
    {
        $plan = Plan::find($request->plan);
        $payLink = $account
        ->newSubscription($plan->name, ($request->get('options')['annual']) ? $plan->stripe_yearly_price_id : $plan->stripe_monthly_price_id)
        ->quantity($request->input('options.quantity'))
        ->allowPromotionCodes()
        ->checkout([
            'success_url' => route('payment.billing', $account->id),
            'cancel_url' => route('payment.checkout', $account->id),
        ]);

        return response()->json(['link' => $payLink]);
    }

    public function billing(Account $account)
    {
        $receipts = [];
        $paymentMethods = $account->paymentMethods();
        $intent = $account->createSetupIntent();
        // $receipt = $receipts[0];
        // dd($receipt->subscription->name, $receipt->quantity, $receipts[0]->amount, $receipt->tax);
        return view('payment.billing', compact('receipts', 'paymentMethods', 'intent'));
    }

    public function billing_portal(Account $account, Request $request)
    {
        return view('payment.accountBillingInfo');
        /*if($account->hasStripeId()){
            $account->createOrGetStripeCustomer();
        }
        return $request->account->redirectToBillingPortal(route('sites.index', $account));*/
    }
}
