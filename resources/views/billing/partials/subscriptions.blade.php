@foreach ($currentAccount->sites as $site )
    <div class="card card-bordered">
        <div class="card-body">
            <h3>{{ $site->subscription->displayName }}</h3>
            <p>{{ __('Your subscription period is :period', ['period' => \Str::title($site->subscription->period)])  }}</p>
            <p>{{ __('Subscription Started on: :start', ['start' => $site->subscription->created_at->format('Y-m-d')]) }}</p>
            <p>{{ __('Assoicated with :site', ['site' => $site->subscription->site->name]) }}</a> 
        </div>
    </div>
@endforeach
