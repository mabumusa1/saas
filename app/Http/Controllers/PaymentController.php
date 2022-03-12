<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutLinkRequest;
use App\Http\Requests\makePayLinkRequest;
use App\Models\Account;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\JsonResponse
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

    public function billing_portal(Account $account, Request $request)
    {
        return view('payment.accountBillingInfo');
        /*if($account->hasStripeId()){
            $account->createOrGetStripeCustomer();
        }
        return $request->account->redirectToBillingPortal(route('sites.index', $account));*/
    }
}
