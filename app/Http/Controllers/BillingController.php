<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBillingRequest;
use App\Models\Account;
use App\Models\Plan;
use Illuminate\Http\Request;

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
    public function manageSubscriptions(Account $account)
    {
        return view('billing.manageSubscriptions');
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

    public function destroy(Account $account)
    {
        $paymentMethod = $account->defaultPaymentMethod();
        $paymentMethod->delete();

        return back();
        // $account->deletePaymentMethods();
    }
}
