<x-base-layout>
    <div class="card card-bordered shadow-sm">
        <div class="card-header">
            <h3 class="card-title">{{$currentAccount->name}}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-6">
                    @include('billing.partials.info')
                </div>
                <div class="col-6">
                    @include('billing.partials.cards')
                </div>
            </div>
        </div>
    </div>
</x-base-layout>