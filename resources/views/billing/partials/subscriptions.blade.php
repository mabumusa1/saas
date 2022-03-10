<div class="card card-bordered border-gray-600 border-dotted">
    <div class="card-body">
        <div class="mb-10">
            <h2>{{ __('My Subscriptions') }}</h2>
            @foreach ($currentAccount->subscriptions() as $subscription )
                dd($subscription)
            @endforeach
        </div>
    </div>
</div>
