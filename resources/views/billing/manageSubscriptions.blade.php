<?php
$selectedPlan = $plans->first();
if(request()->has('plan') && $plans->where('id', request()->input('plan'))->count() == 1){
    $selectedPlan = $plans->where('id', request()->input('plan'))->first();
}
?>
<x-base-layout>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <div class="card card-bordered border-gray-600 shadow-sm">
                        <div class="card-body">
                            <h2 class="mb-4 text-center">{{ __('My Susbscriptions') }}</h2>
                            @include('billing.partials.subscriptions')
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card card-bordered border-gray-600 shadow-sm">
                        <div class="card-body">
                            <h2 class="mb-4 text-center">{{ __('Add a new subscription') }}</h2>
                            <div class="card" id="kt_pricing">
                                <!--begin::Nav group-->
                                <div class="nav-group nav-group-outline mx-auto mb-15" data-kt-buttons="true">
                                    <a href="#" class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active" data-kt-plan="month">Monthly</a>
                                    <a href="#" class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3" data-kt-plan="annual">Annual</a>
                                </div>
                                <!--end::Nav group-->                        
                            </div>
                            <label for="contactsNumber" class="form-label">{{ __('How many contacts do you have?') }}</label>                            
                            <select id="contactsNumber" class="form-select form-select-lg mb-3" aria-label="{{ __('Select your number of contacts') }}">
                                @foreach ($plans as $plan )
                                <option value="{{ $plan->id }}" {{ ($plan->id == $selectedPlan->id) ? 'selected' : '' }}>{{ $plan->contacts }}</option>
                                @endforeach
                            </select>
                              
                            <div class="d-flex h-100 align-items-center">
                                <!--begin::Option-->
                                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                    <!--begin::Heading-->
                                    <div class="mb-7 text-center">
                                        <!--begin::Title-->
                                        <h1 class="text-dark mb-5 fw-boldest" id="planTitle">{{ $selectedPlan->display_name }}</h1>
                                        <!--end::Title-->
                                        <!--begin::Description-->
                                        <div class="fw-bold mb-5" id="planDescription">{{ $selectedPlan->short_description }}</div>
                                        <!--end::Description-->
                                        <!--begin::Price-->
                                        <div class="text-center" id="plan_price">
                                            <span class="mb-2 text-primary">{{ __('$') }}</span>
                                            <span id="priceSpan" class="fs-3x fw-bolder text-primary" data-kt-plan-price-month="{{ $selectedPlan->monthly_price }}" data-kt-plan-price-annual="{{ $selectedPlan->yearly_price }}">{{ $selectedPlan->monthly_price  }}</span>
                                            <span class="fs-7 fw-bold opacity-50">/ 
                                            <span data-kt-element="period">{{ __('Mon') }}</span></span>
                                        </div>
                                        <!--end::Price-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Features-->
                                    <div class="w-100 mb-10" id="features">
                                        @foreach ($plan->features as $feature )
                                        <div class="d-flex align-items-center mb-5">
                                            <span class="fw-bold fs-6 text-gray-800 flex-grow-1 pe-3">{{ $feature }}</span>
                                            <span class="svg-icon svg-icon-1 svg-icon-success">
                                                {!! get_svg_icon("icons/duotune/general/gen043.svg") !!}
                                            </span>
                                        </div>
                                        <!--end::Item-->                                        
                                            
                                        @endforeach
                                    </div>
                                    <!--end::Features-->
                                    <!--begin::Select-->
                                    <form method="POST" action="{{ route('billing.subscribe', [$currentAccount->id, $selectedPlan->id]) }}">
                                        @csrf
                                        <input name="period" type="hidden" id="plan_peroid" value="month" class="btn btn-lg btn-primary" />
                                        <input  type="submit" value="{{ __('Subscribe') }}" class="btn btn-lg btn-primary" />
                                    </form>
                                    <!--end::Select-->
                                </div>
                                <!--end::Option-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')

<script>
"use strict";
var KTPricingGeneral = function() {
    var n, t, e, a = function(t) {
        [].slice.call(document.querySelector('#plan_price').querySelectorAll("[data-kt-plan-price-month]")).map((function(n) {
            var e = n.getAttribute("data-kt-plan-price-month"),
                a = n.getAttribute("data-kt-plan-price-annual");
            "month" === t ? n.innerHTML = e : "annual" === t && (n.innerHTML = a)
        }))
    };
    return {
        init: function() {
            var planPeroid = document.querySelector('#plan_peroid')
            n = document.querySelector("#kt_pricing"), t = n.querySelector('[data-kt-plan="month"]'), e = n.querySelector('[data-kt-plan="annual"]'), t.addEventListener("click", (function(n) {
                n.preventDefault(), a("month"), planPeroid.value = "month", planPeroid.value = "month"
            })), e.addEventListener("click", (function(n) {
                n.preventDefault(), a("annual"), planPeroid.value = "year"
            }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function() {
    KTPricingGeneral.init()
    @if (request()->has('period') && request()->input('period') == 'year')
     document.querySelector('[data-kt-plan="annual"]').click()
    @endif
}));    

document.getElementById("contactsNumber").addEventListener("change", (event) => {
    const location = "{{ route('billing.manageSubscriptions', [$currentAccount->id]) }}"
    window.location.href = location + "?plan=" + event.target.value + "&period=" + document.querySelector('#plan_peroid').value;    
});
</script>
@endpush
</x-base-layout>

