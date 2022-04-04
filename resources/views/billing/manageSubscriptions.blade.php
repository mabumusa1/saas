<?php
$selectedPlan = $plans->first();
if (request()->has('plan') && $plans->where('id', request()->input('plan'))->count() == 1) {
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
                                    <a href="#"
                                        class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active"
                                        data-kt-plan="month">Monthly</a>
                                    <a href="#" class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3"
                                        data-kt-plan="annual">Annual</a>
                                </div>
                                <!--end::Nav group-->
                            </div>
                            <label for="contactsNumber"
                                class="form-label">{{ __('How many contacts do you have?') }}</label>
                            <select id="contactsNumber" class="form-select form-select-lg mb-3"
                                aria-label="{{ __('Select your number of contacts') }}">
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}"
                                        {{ $plan->id == $selectedPlan->id ? 'selected' : '' }}>
                                        {{ $plan->contacts }}</option>
                                @endforeach
                            </select>

                            <div class="d-flex h-100 align-items-center">
                                <!--begin::Option-->
                                <div
                                    class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                                    <!--begin::Heading-->
                                    <div class="mb-7 text-center">
                                        <!--begin::Title-->
                                        <h1 class="text-dark mb-5 fw-boldest" id="planTitle">
                                            {{ $selectedPlan->display_name }}</h1>
                                        <!--end::Title-->
                                        <!--begin::Description-->
                                        <div class="fw-bold mb-5" id="planDescription">
                                            {{ $selectedPlan->short_description }}</div>
                                        <!--end::Description-->
                                        <!--begin::Price-->
                                        <div class="text-center" id="plan_price">
                                            <span class="mb-2 text-primary">{{ __('$') }}</span>
                                            <span id="priceSpan" class="fs-3x fw-bolder text-primary"
                                                data-kt-plan-price-month="{{ $selectedPlan->monthly_price }}"
                                                data-kt-plan-price-annual="{{ $selectedPlan->yearly_price }}">{{ $selectedPlan->monthly_price }}</span>
                                            <span class="fs-7 fw-bold opacity-50">/
                                                <span data-kt-element="period">{{ __('Mon') }}</span></span>
                                        </div>
                                        <!--end::Price-->
                                    </div>
                                    <!--end::Heading-->
                                    <!--begin::Features-->
                                    <div class="w-100 mb-10" id="features">
                                        @foreach ($plan->features as $feature)
                                            <div class="d-flex align-items-center mb-5">
                                                <span
                                                    class="fw-bold fs-6 text-gray-800 flex-grow-1 pe-3">{{ $feature }}</span>
                                                <span class="svg-icon svg-icon-1 svg-icon-success">
                                                    {!! get_svg_icon('icons/duotune/general/gen043.svg') !!}
                                                </span>
                                            </div>
                                            <!--end::Item-->
                                        @endforeach
                                    </div>
                                    <!--end::Features-->
                                    @if ($currentAccount->hasDefaultPaymentMethod())
                                        <!--begin::Select-->
                                        <form method="POST"
                                            action="{{ route('billing.subscribe', [$currentAccount->id, $selectedPlan->id]) }}">
                                            @csrf
                                            <input name="period" type="hidden" id="plan_peroid" value="month"
                                                class="btn btn-lg btn-primary" />
                                            <input type="submit" value="{{ __('Subscribe') }}"
                                                class="btn btn-lg btn-primary" />
                                        </form>
                                        <!--end::Select-->
                                    @else
                                        <!--begin::Button-->
                                        <div class="text-center">
                                            <button class="btn btn-lg btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#billing_info_modal">{{ __('Subscribe') }}</a>
                                        </div>
                                        <!--end::Button-->
                                    @endif
                                </div>
                                <!--end::Option-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="billing_info_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Card</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <div class="modal-body">
                    <div id="card-element-error" class="mt-2 mb-5 text-red" role="alert"></div>
                    <div id="card-element" class="form-control" style="height:3em"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary me-2 mb-2" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button id="card-button" type="submit" class="btn btn-primary me-2 mb-2"
                        data-secret="{{ $intent->client_secret }}">
                        <span class="indicator-label">
                            {{ __('Save payment method') }}
                        </span>
                        <span class="indicator-progress">
                            {{ __('Please wait...') }} <span
                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe('{{env('STRIPE_KEY')}}');
const elements = stripe.elements();
const cardElement = elements.create('card', {hidePostalCode: true})
const billingEmail = document.getElementById('billing-email');
const billingName = document.getElementById('billing-name');
const cardButton = document.getElementById('card-button');
const errorHandler = document.getElementById('card-element-error');
const clientSecret = cardButton.dataset.secret;
const cardElementError = document.getElementById('card-element-error');
cardElement.mount('#card-element');

cardElement.on('change', function (event) {
    if (event.error) {
        cardElementError.innerHTML = `
            <span><i class="fas fa-exclamation-circle text-danger"></i></span>
            <span class="text-danger">${event.error.message}</span>`;
    } else {
        cardElementError.textContent = " ";
    }
});

cardButton.addEventListener('click', async (event) => {
    event.preventDefault();
    cardElement.update({
        'disabled': true
    });
    cardButton.disabled = true;
    cardButton.setAttribute("data-kt-indicator", "on");

    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement
            }
        }
    );

    if (error) {
        cardElementError.innerHTML = `
            <span><i class="fas fa-exclamation-circle text-danger"></i></span>
            <span class="text-danger">${error.message}</span>`;
        cardElement.update({
            'disabled': false
        });
        cardButton.disabled = false;
        cardButton.removeAttribute("data-kt-indicator");
    } else {
        axios.put('{{route("billing.update", $currentAccount->id)}}', {payment_method: setupIntent.payment_method}, {headers: {'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')}})
        .then(function(data){
            errorHandler.textContent = "";
            location.reload();
        }).catch(function(error){
            cardElementError.innerHTML = `
            <span><i class="fas fa-exclamation-circle text-danger"></i></span>
            <span class="text-danger">${error.message}</span>`;
            cardElement.update({
                'disabled': false
            });
            cardButton.disabled = false;
            cardButton.removeAttribute("data-kt-indicator");

        });
    }
});
</script>
    @endpush
    @push('scripts')

        <script>
            "use strict";
            var KTPricingGeneral = function() {
                var n, t, e, a = function(t) {
                    [].slice.call(document.querySelector('#plan_price').querySelectorAll("[data-kt-plan-price-month]"))
                        .map((function(n) {
                            var e = n.getAttribute("data-kt-plan-price-month"),
                                a = n.getAttribute("data-kt-plan-price-annual");
                            "month" === t ? n.innerHTML = e : "annual" === t && (n.innerHTML = a)
                        }))
                };
                return {
                    init: function() {
                        var planPeroid = document.querySelector('#plan_peroid')
                        n = document.querySelector("#kt_pricing"), t = n.querySelector('[data-kt-plan="month"]'), e = n
                            .querySelector('[data-kt-plan="annual"]'), t.addEventListener("click", (function(n) {
                                n.preventDefault(), a("month"), planPeroid.value = "month", planPeroid.value =
                                    "month"
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
                window.location.href = location + "?plan=" + event.target.value + "&period=" + document.querySelector(
                    '#plan_peroid').value;
            });
        </script>
    @endpush
</x-base-layout>
