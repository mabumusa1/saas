<x-base-layout>
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update payment method</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div id="card-element"></div>
                    <div class="form-group">
                        <label for="holder">Holder name</label>
                        <input id="holder" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="card-number">Card number</label>
                        <div class="input-group">
                            <div id="card-number" class="form-control"></div>
                            <div id="card-expiry" class="form-control"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="card-cvc">CVC</label>
                        <div class="form-group">
                            <div id="card-cvc" class="form-control"></div>
                        </div>
                    </div>

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="card-button"
                        data-secret="{{ $intent->client_secret }}">Update Payment Method</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body">
            <div id="kt_billing_creditcard" class="tab-pane fade active show" role="tabpanel">
                <!--begin::Title-->
                <h3 class="mb-5">My Cards</h3>
                <!--end::Title-->
                <!--begin::Row-->
                <div class="row gx-9 gy-6">
                    @foreach ($paymentMethods as $paymentMethod)
                        <!--begin::Col-->
                        <div class="col-xl-6">
                            <!--begin::Card-->
                            <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                                <!--begin::Info-->
                                <div class="d-flex flex-column py-2">
                                    <!--begin::Owner-->
                                    <div class="d-flex align-items-center fs-4 fw-bolder mb-5">
                                        {{ $paymentMethod->billing_details->name }}</div>
                                    <!--end::Owner-->
                                    <!--begin::Wrapper-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Icon-->
                                        <img src="{{ asset(theme()->getMediaUrlPath() . '/svg/card-logos/' . $paymentMethod->card->brand . '.svg') }}"
                                            alt="" class="me-4">
                                        <!--end::Icon-->
                                        <!--begin::Details-->
                                        <div>
                                            <div class="fs-4 fw-bolder">{{ Str::title($paymentMethod->card->brand) }}
                                                **** {{ $paymentMethod->card->last4 }}</div>
                                            <div class="fs-6 fw-bold text-gray-400">Card expires at
                                                {{ $paymentMethod->card->exp_month }}/{{ $paymentMethod->card->exp_year }}
                                            </div>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-2">
                                    <button class="btn btn-sm btn-light btn-active-light-primary paddle_button"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_1">Edit</button>
                                    {{-- <button class="btn btn-sm btn-light btn-active-light-primary paddle_button"
                                        data-theme="none" data-override="{{ $paymentMethod->updateUrl() }}"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">Edit</button> --}}
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end::Col-->
                    @endforeach
                </div>
                <!--end::Row-->
            </div>
        </div>
    </div>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body">
            <!--begin::Title-->
            <h3 class="mb-5">My Invoices</h3>
            <div class="">
                <table class="table table-responsive table-rounded border">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border border-gray-200 table-active">
                            <th>Subscription</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Tax</th>
                            <th class="text-center">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receipts as $receipt)
                            <tr class="fw-bold fs-6 text-gray-800 border border-gray-200">
                                <td>{{ $receipt->subscription->name }}</td>
                                <td class="text-center">{{ $receipt->quantity }}</td>
                                <td class="text-center">{{ $receipt->tax }}</td>
                                <td class="text-center">{{ $receipt->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe(
                'pk_test_51KY8wAJJANQIX4AvfvOhK9r1X40Wdzh2EXopxzcyHbwylMgKBpEHKtJhloE93u8CGoaz7IOnihxBCAr4skqwhM0N00aKqlXsoK'
            );

            const appearance = {
                theme: 'stripe'
            };

            // Pass the appearance object to the Elements instance
            const elements = stripe.elements({
                clientSecret: '{{ $intent->client_secret }}',
                appearance
            });


            const elements = stripe.elements();
            var cardNumberElement = elements.create('cardNumber');
            cardNumberElement.mount('#card-number');
            var cardExpiryElement = elements.create('cardExpiry');
            cardExpiryElement.mount('#card-expiry');
            var cardCVCElement = elements.create('cardCvc');
            cardCVCElement.mount('#card-cvc');


            cardButton.addEventListener('click', async (e) => {
                const {
                    setupIntent,
                    error
                } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardNumberElement,
                            billing_details: {
                                name: cardHolderName.value
                            }
                        }
                    }
                );

                if (error) {
                    // Display "error.message" to the user...
                } else {
                    // The card has been verified successfully...
                }
            });
        </script>
    @endpush
</x-base-layout>
