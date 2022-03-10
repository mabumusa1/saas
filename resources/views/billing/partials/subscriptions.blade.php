@foreach ($currentAccount->subscriptions as $subscription )
    <div class="card card-bordered">
        <div class="card-body">
            <h3>{{ $subscription->displayName}}</h3>
            <p>{{ $subscription->stripe_status }}</p>
            <p>{{ $subscription->quantity }}</p>
            <p>{{ $subscription->created_at }}</p>
            {{ $subscription->items }}
            <p>{{ __('Assoicated with Site')  }}
        </div>
    </div>
@endforeach
