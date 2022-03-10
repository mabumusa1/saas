@foreach ($currentAccount->subscriptions->groupBy('name')->all() as $subscription )
    <div class="card card-bordered">
        <div class="card-body">

            <h3>{{ $subscription->first()->displayName }}</h3>
            {{-- <p>{{ $subscription->stripe_status }}</p> --}}
            <p>Subscriptions Quantity: {{ $subscription->sum('quantity') }}</p>
            {{-- <p>{{ $subscription->created_at }}</p> --}}
            {{-- {{ $subscription->items }} --}}
            @foreach ($subscription as $item)
                <p>Started at: {{ $item->created_at }}</p>
            @endforeach
            <p>{{ __('Assoicated with Site')  }}
        </div>
    </div>
@endforeach
