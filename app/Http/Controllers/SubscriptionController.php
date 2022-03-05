<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Cashier\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Account $account)
    {
        $subscriptions = $account->subscriptions()->active()->get();

        return view('subscriptions', compact('subscriptions', 'account'));
    }

    public function update(Account $account, Subscription $subscription, Request $request)
    {
        if ($subscription->sites()->count() > (int) $request->qty) {
            return redirect()->back()->with('error', 'this subscription has '.$subscription->sites()->count().' sites, you can not set it to '.$request->qty);
        } else {
            $subscription->updateQuantity($request->qty);

            return redirect()->back();
        }
    }
}
