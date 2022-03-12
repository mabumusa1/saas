@foreach ($currentAccount->subscriptions->groupBy('name')->all() as $subscription )
    <div class="card card-bordered">
        <div class="card-body">
            <h3>{{ $subscription->first()->displayName }}</h3>
            {{-- <p>{{ $subscription->stripe_status }}</p> --}}
            <p>Subscriptions Quantity: {{ $subscription->sum('quantity') }}</p>
            {{-- <p>{{ $subscription->created_at }}</p> --}}
            {{-- {{ $subscription->items }} --}}
            <table class="table table-bordered caption-top">
                <caption>Subscriptions</caption>
                <thead>
                    <tr>
                        <th>Started at</th>
                        <th>Ends at</th>
                        <th>Period</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscription as $item)
                    <tr>
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->ends_at }}</td>
                        <td>{{ Str::title($item->period) }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            <p>{{ __('Assoicated with Site')  }}
        </div>
    </div>
@endforeach
