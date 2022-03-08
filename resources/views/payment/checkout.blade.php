<x-base-layout>
    @push('scripts')
        <script>
            var exceeder = {};
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
                    btn.parentElement.parentElement.parentElement.classList.add(
                        'overlay-block');
                    btn.parentElement.parentElement.parentElement.querySelector('.overlay-layer').classList
                        .remove('d-none');
                    isAnnual = (document.querySelector('.active[data-kt-plan]').getAttribute('data-kt-plan') ===
                        'annual' ? true : false)
                    planId = btn.getAttribute('data-plan-id');
                    quantity = document.querySelector('#amount').value

                    axios.post("{{ route('payment.makeCheckoutLink', $currentAccount->id) }}", {
                        'account': {{ $currentAccount->id }},
                        'plan': planId,
                        'options': {
                            'annual': isAnnual,
                            'quantity': quantity
                        }
                    }).then(function(res) {
                        location.href = res.data.link.url;
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

                    }).finally(function() {
                        btn.parentElement.parentElement.parentElement.classList.remove('overlay-block');
                        btn.parentElement.parentElement.parentElement.querySelector('.overlay-layer')
                            .classList.add('d-none');
                    });
                })
            })

            var plans = {!! json_encode($plans) !!};

            function createSliderValues(values) {
                const steps = 100 / values.length;
                let sliderValues = {};
                values.forEach(function(value, index) {
                    if (index === 0) {
                        sliderValues['min'] = parseInt(value);
                    } else {
                        sliderValues[(index * steps) + '%'] = parseInt(value);
                    }
                })
                exceeder.value = parseInt(values[values.length - 1] + 1000);
                exceeder.label = parseInt(values[values.length - 1]);
                sliderValues['max'] = exceeder.value;
                return sliderValues;

            }


            var slider = document.querySelector("#kt_slider_basic");

            noUiSlider.create(slider, {
                start: 0,
                snap: true,
                connect: true,
                tooltips: [{
                    to: function(value) {
                        var formatter = new Intl.NumberFormat('en-US')
                        if (value == exceeder.value) {
                            return '> ' + formatter.format(exceeder.label);
                        } else {
                            return formatter.format(value);
                        }
                    }
                }],
                connect: true,
                range: createSliderValues(plans.map(function(plan) {
                    return plan.contacts
                }))
            });

            function formatTooltip(values) {
                console.log(values)
            }

            slider.noUiSlider.on("update", function(values, handle) {
                var plan = plans.find(function(plan) {
                    return plan.contacts == values[handle];
                });
                var price = document.querySelector('[data-kt-element="price"]');
                var purchaseButton = document.querySelector('.purchase-button');
                if (plan && plan.contacts <= 100000) {
                    document.querySelector('#plan-name').textContent = plan.name;

                    price.setAttribute('data-kt-plan-price-month', plan.monthly_price);
                    price.setAttribute('data-kt-plan-price-annual', plan.yearly_price);
                    price.textContent = document.querySelector('[data-kt-buttons="true"] .active[data-kt-plan]')
                        .getAttribute('data-kt-plan') == 'month' ? price.innerHTML = plan.monthly_price : price
                        .innerHTML =
                        plan.yearly_price;
                    purchaseButton.setAttribute('data-plan-id', plan.id);
                } else {
                    document.querySelector('#plan-name').textContent = 'Contact us';
                    purchaseButton.value = 'Contact us';
                    purchaseButton.removeAttribute('data-plan-id');

                    price.textContent = '-';
                }


            });
        </script>
        <style>
            .noUi-target {
                background: transparent;
                border-radius: 0;
                border: none;
                box-shadow: none;
            }

            .noUi-connects {
                background: #E4E6EF;
            }

            .noUi-touch-area {
                background: #009EF7;
                border-radius: 50px;
            }

            .noUi-tooltip {
                background: #009EF7;
                color: white
            }

        </style>
    @endpush
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Pricing card-->
            <div class="card" id="kt_pricing">
                <!--begin::Card body-->
                <div class="card-body p-lg-17">

                    <div class="row">
                        <div class="col-8">
                            <div class="nav-group nav-group-outline mx-auto mb-15 d-flex" data-kt-buttons="true">
                                <a href="#"
                                    class="flex-fill btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3 me-2 active"
                                    data-kt-plan="month">Monthly</a>
                                <a href="#"
                                    class="flex-fill btn btn-color-gray-400 btn-active btn-active-secondary px-6 py-3"
                                    data-kt-plan="annual">Annual</a>
                            </div>
                            <div class="mb-0">
                                <label class="form-label">Contacts</label>
                                <div id="kt_slider_basic" class="noUi-lg mt-10"></div>
                            </div>
                        </div>
                        @include('payment.partials.plan', [
                            'plan' => $plans->first(),
                        ])
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Pricing card-->
        </div>
        <!--end::Container-->
    </div>
</x-base-layout>
