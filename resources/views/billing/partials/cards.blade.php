<div class="card card-bordered h-100">
    <div class="card-header bg-gray-200">
        <div class="card-title">
            <h5>{{__('Payment Method')}}</h5>
        </div>
    </div>
    <div class="card-body">
        @if($currentAccount->hasDefaultPaymentMethod() && !request()->has('update'))
            @include('billing.partials.showDefaultCard')            
        @else
            @include('billing.partials.addCard')
        @endif
    </div>
</div>

