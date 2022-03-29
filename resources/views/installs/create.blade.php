<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <!--begin::Stepper-->
                <div class="d-flex flex-column flex-lg-row">
                    <!--begin::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid">
                        <!--begin::Form-->
                        <form method="post"
                            action="{{ route('installs.store', ['account' => $currentAccount, 'install' => $install]) }}"
                            id="install-form" class="form mx-auto" novalidate="novalidate" autocomplete="off">
                            @csrf
                            <input name="type" type="hidden" value="{{ request()->query('env') }}">
                            <!--begin::Group-->
                            <div class="mb-5">
                                <!--begin::Step 2-->
                                <div class="flex-column">
                                    <h3>{{ __('Site name and first install') }}</h3>
                                    <p>{{ __('A site is a group of up to three installs (Production, Staging, Development) under one name') }}
                                    </p>
                                    <div class="mb-10">
                                        <div class="form-group fv-row">
                                            <label>{{ __('Site Name') }}</label>
                                            <span class="form-control form-control-solid">{{ $site->name }}</span>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group  fv-row">
                                                    <label>{{ __('Install Name') }}</label>
                                                    <div
                                                        class="col d-flex gap-3 align-items-center @error('name') is-invalid @enderror">
                                                        <input name="name" type="text"
                                                            class="w-50 form-control form-control-solid @error('name') is-invalid @enderror"
                                                            placeholder="{{ __('Install Name') }}" value="{{ old('name') }}"/>
                                                        <p class="m-0">.steercampaign.com</p>
                                                    </div>
                                                    @error('name')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div>
                                        <h3>{{ __('Install type') }}</h3>
                                        <p>{{ __('Create additional installs later from the Site Overview page.') }}
                                        </p>
                                        <label class="d-block">
                                            <!--end::Description-->
                                            <div class="d-flex me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check-custom form-check-solid form-check-primary me-2">
                                                    <input class="form-check-input" disabled type="radio"
                                                        @if (request()->query('env') === 'prd') checked @endif />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Price-->
                                                <div class="ms-2">
                                                    {!! get_svg_icon('skin/media/icons/duotone/Communication/Share.svg') !!}
                                                    <div class="badge badge-primary ms-2">{{ __('PRD') }}</div>
                                                    <div class="d-flex d-inline-flex flex-column">
                                                        <p class="mb-0">{{ __('Production (live)') }}</p>
                                                        <p>{{ __('Host a public site') }}</p>
                                                    </div>
                                                </div>
                                                <!--end::Price-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                        <label class="d-block">
                                            <!--end::Description-->
                                            <div class="d-flex me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check-custom form-check-solid form-check-primary me-2">
                                                    <input class="form-check-input" disabled type="radio"
                                                        @if (request()->query('env') === 'stg') checked @endif />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Price-->
                                                <div class="ms-2">
                                                    {!! get_svg_icon('skin/media/icons/duotone/Communication/Share.svg') !!}
                                                    <div class="badge badge-warning ms-2">{{ __('STG') }}</div>
                                                    <div class="d-flex d-inline-flex flex-column">
                                                        <p class="mb-0">
                                                            {{ __('Staging (optional sandbox)') }}</p>
                                                        <p>{{ __('Review and test before deploying to Production.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <!--end::Price-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                        <label class="d-block">
                                            <!--end::Description-->
                                            <div class="d-flex me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check-custom form-check-solid form-check-primary me-2">
                                                    <input class="form-check-input" disabled type="radio"
                                                        @if (request()->query('env') === 'dev') checked @endif />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Price-->
                                                <div class="ms-2">
                                                    {!! get_svg_icon('skin/media/icons/duotone/Communication/Share.svg') !!}
                                                    <div class="badge border border-1 border-primary text-primary ms-2">
                                                        {{ __('DEV') }}</div>
                                                    <div class="d-flex d-inline-flex flex-column">
                                                        <p class="mb-0">
                                                            {{ __('Development (optional sandbox)') }}</p>
                                                        <p>{{ __('Build and experiment before deploying to Staging or Production.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <!--end::Price-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                        @error('type')
                                            <div class="form-group is-invalid">
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <!--begin::Step 2-->
                            </div>
                            <!--end::Group-->

                            <!--begin::Actions-->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('sites.index', $currentAccount) }}" type="button"
                                    class="btn btn-secondary btn-cancel">
                                    {{ __('Cancel') }}
                                </a>
                                <button id="btn-submit" type="submit" class="btn btn-primary">
                                    <span class="indicator-label">
                                        {{ __('Add install') }}
                                    </span>
                                </button>
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Stepper-->
            </div>
        </div>

    </div>

    @push('styles')
        <style>
            .form-control.is-valid {
                border-color: #50CD89 !important;
            }

            .form-control.is-invalid {
                border-color: #F1416C !important;
            }

            .fv-plugins-icon[data-field='sitename'],
            .fv-plugins-icon[data-field='installname'] {
                top: 22px !important;
            }

        </style>
    @endpush
    @push('scripts')
        <script>
            document.querySelectorAll('input[name="start"]').forEach(function(el) {
                el.addEventListener('change', function() {
                    if (el.value !== 'blank') {
                        document.querySelector('.installs').classList.remove('d-none');
                    } else {
                        document.querySelector('.installs').classList.add('d-none');
                    }
                })
            })
            var installId = document.querySelector('[name="install_id"]');
            installId.addEventListener('change', function() {
                installId.classList.remove('is-invalid');
            })
            var element = document.querySelector("#create_stepper");
            // Initialize Stepper
            var stepper = new KTStepper(element);

            // Handle next step
            stepper.on("kt.stepper.next", function(stepper) {
                stepper.goNext();
                document.querySelector('.btn-cancel').classList.add('d-none');
            });

            // Handle previous step
            stepper.on("kt.stepper.previous", function(stepper) {
                stepper.goPrevious(); // go previous step
                document.querySelector('.btn-cancel').classList.remove('d-none');
            });
            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            const form = document.getElementById('install-form')
            var validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'name': {
                            validators: {
                                notEmpty: {
                                    message: 'Install name is required'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 40,
                                    message: 'Install name should be at least three characters'
                                }
                            }
                        }
                    },
                    plugins: {
                        trnsformer: new FormValidation.plugins.Transformer({
                            name: {
                                uri: function(field, element, validator) {
                                    var value = element.value;
                                    var uri = 'https://' + value + '.steercampaign.com';
                                    return uri;
                                }
                            }
                        }),
                        trigger: new FormValidation.plugins.Trigger({
                            event: {
                                name: 'blur change keyup',
                            },
                            threshold: {
                                name: 1,
                            }
                        }),
                        submitButton: new FormValidation.plugins.SubmitButton(),
                        icon: new FormValidation.plugins.Icon({
                            valid: 'fa fa-check',
                            invalid: 'fa fa-times',
                            validating: 'fa fa-refresh',
                        }),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: 'is-invalid',
                            eleValidClass: 'is-valid'
                        })
                    },
                });

            // Submit button handler
            const submitButton = document.getElementById('btn-submit');
            submitButton.addEventListener('click', function(e) {
                const form = document.getElementById('site-form')
                // Prevent default button action
                e.preventDefault();
                // Validate form before submit
                if (validator) {
                    validator.validate().then(function(status) {

                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;
                            form.submit();
                        }
                    });
                }
            });
        </script>
    @endpush
</x-base-layout>
