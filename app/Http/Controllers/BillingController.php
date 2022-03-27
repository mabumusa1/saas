<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBillingRequest;
use App\Models\Account;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BillingController extends Controller
{
    /**
     * Show The billing dashboard.
     *
     * @param Account $account
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Account $account, Request $request)
    {
        if ($account->hasDefaultPaymentMethod() && ! $request->has('update')) {
            return view('billing.index');
        }

        return view('billing.index', ['intent' => $account->createSetupIntent()]);
    }

    /**
     * Change Billing Information and sync with stripe.
     *
     * @param Account $account
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Account $account, Request $request)
    {
        if ($request->has('payment_method')) {
            $account->createOrGetStripeCustomer(['name' => $account->name, 'email' => $account->email]);
            $paymentMethod = $request->input('payment_method');
            $account->addPaymentMethod($paymentMethod);
            $account->updateDefaultPaymentMethod($paymentMethod);
            $account->updateDefaultPaymentMethodFromStripe();

            return response()->json(['message' => __('Saved Card Information')], 200);
        }
        abort(403);
    }

    /**
     * Update billing information to be synced with Stripe.
     *
     * @param UpdateBillingRequest $request
     *
     * @param Account $account
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBillingRequest $request, Account $account)
    {
        $account->updateStripeCustomer($request->validated());
        $account->update($request->validated());

        return redirect()->back();
    }

    /**
     * Manage Subscriptions dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function manageSubscriptions()
    {
        $plans = Plan::where('available', true)->get();

        return view('billing.manageSubscriptions', ['plans' => $plans]);
    }

    /**
     * Subscribe the account to a plan.
     *
     * @param Account $account
     *
     * @param Plan $plan
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribe(Account $account, Plan $plan, Request $request)
    {
        $request->validate([
            'period' => ['required',
                Rule::in(['year', 'month']),
            ],
        ]);
        $price = null;
        if ($request->input('period') === 'month') {
            $price = $plan->stripe_monthly_price_id;
        } else {
            $price = $plan->stripe_yearly_price_id;
        }
        /* @phpstan-ignore-next-line */
        $account->newSubscription($plan->name, $price)->create($account->defaultPaymentMethod()->id);

        return redirect(route('sites.index', [$account->id]))->with('status', __('New site has been added to your account'));
    }

    /**
     * Subscribe the account to a plan.
     *
     * @param Account $account
     *
     * @param string $invoiceId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function invoice(Account $account, string $invoiceId)
    {
        return $account->downloadInvoice($invoiceId, [
            'vendor' => 'Your Company',
            'product' => 'Your Product',
        ]);
    }
}
