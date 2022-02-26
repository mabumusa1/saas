<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Plan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function generatePaymentLink(Request $request)
    {
        $validated = $request->validate([
            'account' => 'exists:App\Models\Account,id',
            'plan' => 'bail|required|exists:App\Models\Plan,id',
            'options' => 'array|required',
            'options.annual' => 'boolean',
            'options.quantity' => 'integer|between:1,100',
        ]);

        $plan = Plan::find($request->input('plan'));
        $quantity = $request->input('options.quantity', 1);
        $annual = $request->input('options.annual', false);
        $options = $request->input('options');

        return $request->whenHas('account', function ($accountId) use ($plan, $options) {
            $account = Account::find($accountId);

            return response()->json(['link' => $this->makeLink($plan, $account, $options)]);
        }, function () use ($plan, $options) {
            return response()->json(['link' => $this->makeLink($plan, null, $options)]);
        });
    }

    /**
     * @return string
     */
    private function makeLink(Plan $plan, Account $account = null, array $options = [])
    {
        $planRemoteId = ($options['annual']) ? $plan->yearly_id : $plan->monthly_id;
        $returnRoute = ($account) ? route('sites.index', [$account]) : route('login');
        $customerEmail = ($account) ? $account->paddleEmail() : $options['customer_email'];
        $payLink = $account->newSubscription($plan->name, $premium = $planRemoteId)
        ->returnTo($returnRoute)
        ->create([
            'quantity' => $options['quantity'],
            //'customer_email' => $customerEmail,
        ]);

        return $payLink;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function checkout(Account $account)
    {
        $plans = Plan::all();
        $initalPayLinks = [];
        foreach ($plans as $plan) {
            $initalPayLinks[$plan->id] = $this->makeLink($plan, $account, ['annual' => false, 'quantity' => 1]);
        }

        return view('payment.checkout', ['plans' => $plans, 'payLinks' => $initalPayLinks, 'account' => $account]);
    }
}
