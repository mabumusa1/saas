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
    public function generatePaymentLink(Account $account, Plan $plan, bool $yearly = false)
    {
        $planRemoteId = ($yearly) ? $plan->yearly_id : $plan->monthly_id;

        $payLink = $account->newSubscription($plan->name, $premium = $planRemoteId)
        ->returnTo(route('sites.index', [$account]))
        ->create();

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
            $initalPayLinks[$plan->id] = $this->generatePaymentLink($account, $plan);
        }

        return view('payment.checkout', ['plans' => $plans, 'payLinks' => $initalPayLinks, 'account' => $account]);
    }
}
