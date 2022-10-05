<h2>{{ __('My Invoices') }}</h2>
<div class="table-responsive">
<table class="table gs-7 gy-7 gx-7 table-striped">
    <thead>
        <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
            <th>{{ __('Date') }}</th>
            <th>{{ __('Total') }}</th>
            <th>{{ __('Related to site') }}</th>
            <th>{{ __('Download') }}</th>
        </tr>
    </thead>    
    @foreach ($currentAccount->invoices() as $invoice)
        <tr>
            <td>{{ $invoice->date()->toFormattedDateString() }}</td>
            <td>{{ $invoice->total() }}</td>
            <?php
            $subscription = \App\Models\Cashier\Subscription::where('stripe_id', $invoice->subscription)->first();
            ?>
            <td>{{ $subscription->site->name }}</td>
            <td><a href="{{ route('billing.invoice', [$currentAccount->id, $invoice->id]) }} ">Download</a></td>
        </tr>
    @endforeach

</table>
</div>