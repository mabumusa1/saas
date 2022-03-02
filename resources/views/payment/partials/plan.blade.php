<!--begin::Col-->
<div class="col-xl-4">
    <div class="d-flex h-100 align-items-center">
        <!--begin::Option-->
        <div
            class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
            <!--begin::Heading-->
            <div class="mb-7 text-center">
                <!--begin::Title-->
                <h1 class="text-dark mb-5 fw-boldest" id="plan-name">{{ $plan->name }}</h1>
                <!--end::Title-->
                <!--begin::Description-->
                <div class="text-gray-400 fw-bold mb-5">{{ $plan->description }}
                    <br>and new startup
                </div>
                <!--end::Description-->
                <!--begin::Price-->
                <div class="text-center">
                    <span class="mb-2 text-primary">$</span>
                    <span class="fs-3x fw-bolder text-primary" data-kt-element="price"
                        data-kt-plan-price-month="{{ $plan->monthly_price }}"
                        data-kt-plan-price-annual="{{ $plan->yearly_price }}">{{ $plan->monthly_price }}</span>
                    <span class="fs-7 fw-bold opacity-50">/
                        <span data-kt-element="period">Mon</span></span>
                </div>
                <!--end::Price-->
            </div>
            <!--end::Heading-->
            <!--begin::Features-->
            <div class="w-100">
                <div class="d-flex align-items-center mb-5">
                    <span
                        class="fw-bold fs-6 text-gray-800 flex-grow-1 pe-3">Backups</span>
                    <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                    <span class="svg-icon svg-icon-1 svg-icon-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                rx="10" fill="black"></rect>
                            <path
                                d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                                fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <div class="d-flex align-items-center mb-5">
                    <span
                        class="fw-bold fs-6 text-gray-800 flex-grow-1 pe-3">Hosting</span>
                    <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                    <span class="svg-icon svg-icon-1 svg-icon-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                rx="10" fill="black"></rect>
                            <path
                                d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                                fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <div class="d-flex align-items-center mb-5">
                    <span
                        class="fw-bold fs-6 text-gray-800 flex-grow-1 pe-3">Security</span>
                    <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                    <span class="svg-icon svg-icon-1 svg-icon-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                rx="10" fill="black"></rect>
                            <path
                                d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                                fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <div class="d-flex align-items-center mb-5">
                    <span
                        class="fw-bold fs-6 text-gray-800 flex-grow-1 pe-3">Scalablity</span>
                    <!--begin::Svg Icon | path: icons/duotune/general/gen043.svg-->
                    <span class="svg-icon svg-icon-1 svg-icon-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20"
                                rx="10" fill="black"></rect>
                            <path
                                d="M10.4343 12.4343L8.75 10.75C8.33579 10.3358 7.66421 10.3358 7.25 10.75C6.83579 11.1642 6.83579 11.8358 7.25 12.25L10.2929 15.2929C10.6834 15.6834 11.3166 15.6834 11.7071 15.2929L17.25 9.75C17.6642 9.33579 17.6642 8.66421 17.25 8.25C16.8358 7.83579 16.1642 7.83579 15.75 8.25L11.5657 12.4343C11.2533 12.7467 10.7467 12.7467 10.4343 12.4343Z"
                                fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>

            </div>
            <!--end::Features-->

            <!--begin::Dialer-->
            <div class="input-group mb-5 dailer" data-kt-dialer="true" data-kt-dialer-min="1"
                data-kt-dialer-max="100" data-kt-dialer-step="1">
                <!--begin::Input control-->
                <input type="text" class="form-control text-center" readonly
                    placeholder="Amount" value="1" data-kt-dialer-control="input" id="amount" />
                <!--end::Input control-->

                <!--begin::Increase control-->
                <button class="btn btn-icon btn-outline btn-outline-secondary btn-qty"
                    type="button" data-kt-dialer-control="increase">
                    <i class="bi bi-plus fs-1"></i>
                </button>
                <!--end::Increase control-->
            </div>
            <!--end::Dialer-->
            <!--begin::Select-->
            <div class="overlay card-rounded">
                <div class="overlay-wrapper">
                    <form action="{{ route('payment.makeCheckoutLink', $currentAccount->id) }}" method="POST">
                        @csrf
                        <input type="hidden" id="plan-id" name="plan" value="{{$plan->id}}">
                        <input type="hidden" id="account-id" name="account" value="{{$plan->id}}">
                        <input type="hidden" id="is_annual" name="options['annual']" value="false">
                        <input type="hidden" id="quantity" name="options['quantity']" value="1">
                        <input type="submit" value="Buy Now" class="btn btn-success btn-large ml-4 purchase-button" data-plan-id="{{ $plan->id }}">
                    </form>
                </div>
                <div class="overlay-layer card-rounded bg-dark bg-opacity-5 d-none">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <!--end::Select-->
        </div>
        <!--end::Option-->
    </div>
</div>
<!--end::Col-->
