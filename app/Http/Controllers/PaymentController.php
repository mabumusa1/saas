<?php

namespace App\Http\Controllers;

use App\Http\Requests\makePayLinkRequest;
use App\Models\Account;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutLinkRequest;


class PaymentController extends Controller
{

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
        $payLink =  $account
        ->newSubscription($plan->name, ($request->get('options')['annual']) ? $plan->stripe_yearly_price_id : $plan->stripe_monthly_price_id)
        ->allowPromotionCodes()
        ->checkout([
            'success_url' => route('sites.create', $account->id),
            'cancel_url' => route('sites.index', $account->id),
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
        return $request->account->redirectToBillingPortal(route('sites.index', $account));
    }
}