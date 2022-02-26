<?php

namespace App\Http\Controllers;

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
    public function makePayLink(Account $account, makePayLinkRequest $request)
    {
        $plan = Plan::find($request->input('plan'));
        $quantity = $request->input('options.quantity', 1);
        $annual = $request->input('options.annual', false);
        $options = $request->input('options');

        $planRemoteId = ($options['annual']) ? $plan->yearly_id : $plan->monthly_id;

        $customerEmail = '';
        $payLink = '';
        $account = Account::find($request->input('account'));
        $payLink = $account->newSubscription($plan->name, $premium = $planRemoteId)
        //TODO: Add flag to the URL to indeicate that the site is being created
        ->returnTo(route('sites.index', $account->id).'?status=1')
        ->create([
            'quantity' => $options['quantity'],
            'customer_email' => $account->paddleEmail(),
        ]);

        return response()->json(['link' => $payLink]);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function checkout(Account $account)
    {
        $plans = Plan::all();

        return view('payment.checkout', ['plans' => $plans]);
    }


    public function billing(Account $account)
    {
        return view('payment.billing');
    }
}
