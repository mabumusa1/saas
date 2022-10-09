<x-base-layout>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-bordered border-gray-600 shadow-sm">
                        <div class="card-body">
                            <h2 class="mb-4 text-center">{{ __('My Subscriptions') }}</h2>
                            @include('billing.partials.subscriptions')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
