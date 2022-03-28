<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBillingRequest;
use App\Models\Account;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Cashier\Invoice;
use stdClass;
use Symfony\Component\HttpFoundation\Response;

class BillingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Account $account, Request $request)
    {
        if ($account->hasDefaultPaymentMethod() && ! $request->has('update')) {
            return view('billing.index');
        } else {
            return view('billing.index', ['intent' => $account->createSetupIntent()]);
        }
    }

    public function store(Account $account, Request $request)
    {
        if ($request->has('payment_method')) {
            $stripeCustomer = $account->createOrGetStripeCustomer(['name' => $account->name, 'email' => $account->email]);
            $paymentMethod = $request->input('payment_method');
            $account->addPaymentMethod($paymentMethod);
            $account->updateDefaultPaymentMethod($paymentMethod);
            $account->updateDefaultPaymentMethodFromStripe();

            return response()->json(['message' => __('Saved Card Information')], 200);
        } else {
            abort(403);
        }
    }

    public function update(UpdateBillingRequest $request, Account $account)
    {
        $account->updateStripeCustomer($request->validated());
        $account->update($request->validated());

        return redirect()->back();
    }

    public function manageSubscriptions(Account $account, Request $request)
    {
        $plans = Plan::where('available', true)->get();

        return view('billing.manageSubscriptions', compact('plans'));
    }

    public function subscribe(Account $account, Plan $plan, Request $request)
    {
        $validated = $request->validate([
            'period' => ['required',
            Rule::in(['year', 'month']), ],
        ]);
        $price = null;
        if ($request->input('period') == 'month') {
            $price = $plan->stripe_monthly_price_id;
        } else {
            $price = $plan->stripe_yearly_price_id;
        }
        /* @phpstan-ignore-next-line */
        $account->newSubscription($plan->name, $price)->create($account->defaultPaymentMethod()->id);

        return redirect(route('sites.index', [$account->id]))->with('status', __('New site has been added to your account'));
    }

    public function invoice(Account $account, $invoiceId)
    {
        // return $account->subscriptions->first();
        // return $account->subscriptions->first()->previewInvoice('price_1KYcdZJJANQIX4AvM2ySzZzb');
        // return view('cashier::receipt', ['invoice' => $account->findInvoice($invoiceId, [
        //     'vendor' => 'Your Company',
        //     'product' => 'Your Product',
        // ])]);
        return new Response($account->findInvoice($invoiceId, [
            'vendor' => 'Your Company',
            'product' => 'Your Product',
        ])->pdf([
            'vendor' => 'Your Company',
            'product' => 'Your Product',
        ]), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
