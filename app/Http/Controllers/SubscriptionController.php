<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Laravel\Paddle\Subscription;

class SubscriptionController extends Controller
{
    public function index(Account $account)
    {
        $subscriptions = $account->subscriptions()->active()->get();

        return view('subscriptions', compact('subscriptions'));
    }

    public function cancel(Account $account, Subscription $subscription)
    {
        $subscription->cancel();

        return to_route('subscriptions.index', compact('account'));
    }
}
