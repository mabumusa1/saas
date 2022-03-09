<div class="card card-bordered">
    <div class="card-header bg-gray-200">
        <div class="card-title">
            <h5>{{__('Payment Method')}}</h5>
        </div>
    </div>
    <div class="card-body">
        @if($currentAccount->hasDefaultPaymentMethod())
            @include('billing.partials.showCards')
        @else
            @include('billing.partials.addCard')
        @endif
    </div>
</div>

