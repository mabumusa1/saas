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
    public function makePayLink(makePayLinkRequest $request)
    {
        $plan = Plan::find($request->input('plan'));
        $quantity = $request->input('options.quantity', 1);
        $annual = $request->input('options.annual', false);
        $options = $request->input('options');

        $planRemoteId = ($options['annual']) ? $plan->yearly_id : $plan->monthly_id;
        $returnRoute = '';
        $customerEmail = '';
        $payLink = '';
        if (Auth::check()) {
            $account = Account::find($request->input('account'));
            $payLink = $account->newSubscription($plan->name, $premium = $planRemoteId)
            ->returnTo($returnRoute)
            ->create([
                'quantity' => $options['quantity'],
                'customer_email' => $account->paddleEmail(),
            ]);
        } else {
            //TODO: Add route called thank you for unauthenicated users
            //TODO: Create payment links without the need for an account object
            // the account object and the user must be created when we get a webhook from paddle
            // https://developer.paddle.com/api-reference/b3A6MzA3NDQ3MjM-generate-pay-link
            $returnRoute = ($account) ? route('sites.index', [$account]) : route('login');
            $customerEmail = $options['customer_email'];
        }

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
}
