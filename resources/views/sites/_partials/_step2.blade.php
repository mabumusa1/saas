<div class="card card-bordered mb-5" id="billingDiv">
    <div class="card-header bg-secondary">
        <h3 class="card-title">{{ __('2) How many contacts do you have?') }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-8">
                <label for="planId"
                class="form-label">{{ __('How many contacts do you have?') }}</label>
                <select name="planId" id="planId" class="form-select form-select-lg mb-3"
                aria-label="{{ __('Select your number of contacts') }}">
                </select>
                <input name="period" type="hidden" id="plan_peroid" value="month" />                        
                <div class="d-flex h-100 align-items-center">
                    <!--begin::Option-->
                    <div
                        class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                        <h3>{{ __('Features') }}</h3>
                        <!--begin::Features-->
                        <div class="w-100 mb-10" id="features">
                                <div class="d-flex align-items-center mb-5" id="features">
                                </div>
                                <!--end::Item-->
                        </div>
                        <!--end::Features-->
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card" id="kt_pricing">
                    <!--begin::Nav group-->
                    <div class="nav-group nav-group-outline mx-auto" data-kt-buttons="true">
                        <a href="#"
                            class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active"
                            data-kt-plan="month">{{ __('Monthly') }}</a>
                        <a href="#" class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3"
                            data-kt-plan="annual">{{ __('Annual') }}</a>
                    </div>
                    <!--end::Nav group-->
                </div>
                <div class="d-flex h-100 align-items-center">
                    <!--begin::Option-->
                    <div
                        class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
                        <!--begin::Heading-->
                        <div class="mb-7 text-center">
                            <!--begin::Title-->
                            <h1 class="text-dark mb-5 fw-boldest" id="planTitle">
                                </h1>
                            <!--end::Title-->
                            <!--begin::Description-->
                            <div class="fw-bold mb-5">
                                <span id="planDescription"></span>
                            </div>
                            <!--end::Description-->
                            <!--begin::Price-->
                            <div class="text-center" id="plan_price">
                                <span class="mb-2 text-primary">{{ __('$') }}</span>
                                <span id="priceSpan" class="fs-3x fw-bolder text-primary"
                                    data-kt-plan-price-month=""
                                    data-kt-plan-price-annual=""></span>
                                <span class="fs-7 fw-bold opacity-50">/
                                    <span data-kt-element="period">{{ __('Mon') }}</span></span>
                            </div>
                            <!--end::Price-->
                        </div>
                        <!--end::Heading-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>