<x-base-layout>
    @push('styles')
        @paddleJS
    @endpush
    @push('scripts')
    <script>
    var slider = document.querySelector("#kt_slider_soft_limits");
    
    noUiSlider.create(slider, {
        start: 30,
        range: {
            min: 30,
            max: 400
        },
        step: 29,
    });
    slider.noUiSlider.on("update", function (values, handle) {
        document.querySelector(".price").innerHTML = values[handle];
    });
    </script>
    @endpush
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Pricing card-->
            <div class="card" id="kt_pricing">
                <!--begin::Card body-->
                <div class="card-body p-lg-17">
                    <!--begin::Plans-->
                    <div class="d-flex flex-column">
                        <!--begin::Heading-->
                        <div class="mb-13 text-center">
                            <h1 class="fs-2hx fw-bolder mb-5">Choose Your Plan</h1>
                            <div class="text-gray-400 fw-bold fs-5">If you need more info about our pricing, please check
                            <a href="#" class="link-primary fw-bolder">Pricing Guidelines</a>.</div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Nav group-->
                        <div class="nav-group nav-group-outline mx-auto mb-15" data-kt-buttons="true">
                            <a href="#" class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active" data-kt-plan="month">Monthly</a>
                            <a href="#" class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3" data-kt-plan="annual">Annual</a>
                        </div>
                        <!--end::Nav group-->
                        <!--begin::Row-->
                        <div class="row g-10">
                            <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-0">SME Plans</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab-1">Enterprise Plans</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pricing-plans">
                                @foreach ($plans->chunk(3) as $index => $plansGroup )
                                
                                    <div class="tab-pane fade show <?php echo ($index == 0) ? 'active' : '' ?>" id="tab-{{ $index }}" role="tabpanel">
                                        <div class="row g-10">
                                            @foreach ($plansGroup as $plan )
                                                @include('payment.partials.plan', ['plan' => $plan, 'payLinks' => $payLinks])
                                            @endforeach
                                        </div>
                                    </div>                                    
                                @endforeach
                            </div>
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Plans-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Pricing card-->
        </div>
        <!--end::Container-->
    </div>
</x-base-layout>


