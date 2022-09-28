@foreach ($currentAccount->subscriptions()->active()->get() as $subscription )
    <div class="card card-bordered">
        <div class="card-body">
            {{ dd($subscription->items()->first()->stripe_price) }}
            <h3>{{ $subscription->displayName }}</h3>
            <p>{{ $subscription->created_at }}</p>
            <p>{{ __('Assoicated with Site')  }}
        </div>
    </div>
@endforeach
