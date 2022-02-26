<x-base-layout>
    @push('styles')
        @paddleJS
    @endpush
    <?php
    $subscription = $currentAccount->subscription('Small Installs')->all();

    ?>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body">
            <div id="kt_billing_creditcard" class="tab-pane fade active show" role="tabpanel">
                <!--begin::Title-->
                <h3 class="mb-5">My Cards</h3>
                <!--end::Title-->
                <!--begin::Row-->
                <div class="row gx-9 gy-6">
                    @foreach ($subscription as $subscription)
                        <!--begin::Col-->
                        <div class="col-xl-6">
                            <!--begin::Card-->
                            <div class="card card-dashed h-xl-100 flex-row flex-stack flex-wrap p-6">
                                <!--begin::Info-->
                                <div class="d-flex flex-column py-2">
                                    <!--begin::Owner-->
                                    <div class="d-flex align-items-center fs-4 fw-bolder mb-5">
                                        {{ $subscription->paddleEmail() }}</div>
                                    <!--end::Owner-->
                                    <!--begin::Wrapper-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Icon-->
                                        <img src="{{ asset(theme()->getMediaUrlPath() . '/svg/card-logos/visa.svg') }}"
                                            alt="" class="me-4">
                                        <!--end::Icon-->
                                        <!--begin::Details-->
                                        <div>
                                            <div class="fs-4 fw-bolder">{{ Str::title($subscription->cardBrand()) }}
                                                **** {{ $subscription->cardLastFour() }}</div>
                                            <div class="fs-6 fw-bold text-gray-400">Card expires at
                                                {{ $subscription->cardExpirationDate() }}</div>
                                        </div>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Wrapper-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Actions-->
                                <div class="d-flex align-items-center py-2">
                                    <button class="btn btn-sm btn-light btn-active-light-primary paddle_button"
                                        data-theme="none" data-override="{{ $subscription->updateUrl() }}"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_new_card">Edit</button>
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
</x-base-layout>
