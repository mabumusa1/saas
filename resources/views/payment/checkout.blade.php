<x-base-layout>
    @push('scripts')
        <script>
            document.querySelector('[data-kt-buttons="true"]').children.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.target.getAttribute('data-kt-plan')
                    document.querySelectorAll('[data-kt-element="price"]').forEach(function(el) {
                        el.textContent = el.getAttribute('data-kt-plan-price-' + e.target.getAttribute(
                            'data-kt-plan'));
                        el.parentElement.querySelector('[data-kt-element="period"]').textContent = e
                            .target.getAttribute('data-kt-plan')[0].toUpperCase() + e.target
                            .getAttribute('data-kt-plan').substring(1, 3)
                    })
                })
            })


            document.querySelectorAll('.purchase-button').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    btn.parentElement.parentElement.parentElement.querySelector('.overlay').classList.add(
                        'overlay-block');
                    btn.parentElement.parentElement.parentElement.querySelector('.overlay-layer').classList
                        .remove('d-none');
                    isAnnual = (document.querySelector('.active[data-kt-plan]').getAttribute('data-kt-plan') ===
                        'annual' ? true : false)
                    planId = btn.getAttribute('data-plan-id');
                    quantity = document.querySelector('#amount-' + planId).value

                    axios.post("{{ route('payment.makeCheckoutLink', $currentAccount->id) }}", {
                        'account': {{ $currentAccount->id }},
                        'plan': planId,
                        'options': {
                            'annual': isAnnual,
                            'quantity': quantity
                        }
                    }).then(function(res) {
                        Paddle.Checkout.open({
                            override: res.data.link
                        });
                    }).catch(function(err) {
                        toastr.options = {
                            "closeButton": false,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toastr-top-right",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };

                        toastr.error("Something went wrong, please try again later");
                        //TODO: Show message that there is an error with the request
                        console.log(err);

                    }).finally(function(){
                        btn.parentElement.parentElement.parentElement.querySelector('.overlay')
                            .classList.remove('overlay-block');
                        btn.parentElement.parentElement.parentElement.querySelector('.overlay-layer')
                            .classList.add('d-none');
                    });
                })
            })
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
                                <a href="#" class="link-primary fw-bolder">Pricing Guidelines</a>.
                            </div>
                        </div>
                        <!--end::Heading-->
                        <!--begin::Nav group-->
                        <div class="nav-group nav-group-outline mx-auto mb-15" data-kt-buttons="true">
                            <a href="#"
                                class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active"
                                data-kt-plan="month">Monthly</a>
                            <a href="#" class="btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3"
                                data-kt-plan="annual">Annual</a>
                        </div>
                        <!--end::Nav group-->
                        <!--begin::Row-->
                        <div class="row g-10">
                            <ul class="nav nav-pills justify-content-center">
                                <li class="nav-item flex-fill text-center">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-0">SME Plans</a>
                                </li>
                                <li class="nav-item flex-fill text-center">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab-1">Enterprise Plans</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pricing-plans">
                                @foreach ($plans->chunk(3) as $index => $plansGroup)
                                    <div class="tab-pane fade show <?php echo $index == 0 ? 'active' : ''; ?>" id="tab-{{ $index }}"
                                        role="tabpanel">
                                        <div class="row g-10">
                                            @foreach ($plansGroup as $plan)
                                                @include('payment.partials.plan', ['plan' => $plan])
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