<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="create_stepper">
                    <!--begin::Aside-->
                    <!--begin::Content-->
                    <div class="flex-row-fluid">
                        <!--begin::Form-->
                        <form id="site-form" class="form mx-auto" novalidate="novalidate" autocomplete="off">
                            @csrf
                            <!--begin::Group-->
                            <div class="mb-5">
                                <!--begin::Step 1-->
                                <div class="flex-column current" data-kt-stepper-element="content">
                                    <h3 class="text-dark mb-8">{{ __('Who owns the site?') }}</h3>
                                    <!-- Begin Site Type -->
                                    <div class="mb-10">
                                        <div class="form-check form-check-custom form-check-lg">
                                            <input name="type" class="form-check-input" type="radio" value="mine"
                                                id="radioMine"
                                                @if ($subscriptions->count() === 0) disabled @else checked @endif>
                                            <label class="form-check-label" for="radioMine">
                                                {{ __('This site is mine; it will count towards my site allowance') }}
                                                <br />
                                                {{ __('You have ') . $subscriptions->sum('quantity') - $subscriptions->sum('sites_count') }}
                                                of {{ $totalActiveSubscriptions }} {{ __('sites available.') }}
                                                @if ($subscriptions->count() === 0)
                                                    {{ __('Delete site or ') }} <a class="text-primary"
                                                        href="{{ route('billing.index', [$currentAccount]) }}">
                                                        {{ __('Upgrade your plan') }}</a>
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-10 @if ($subscriptions->count() === 0) d-none @endif"
                                        id="subscriptions">
                                        <div class="form-group">
                                            <select name="subscription_id" id="subscription_id" class="form-control">
                                                @foreach ($subscriptions as $subscription)
                                                    <option value="{{ $subscription->id }}"
                                                        @if ($subscription->id == $currentAccount->subscription_id) selected @endif>

                                                        {{ $subscription->displayName }}
                                                        @if ($subscription->quantity - $subscription->sites_count > 0)
                                                            ({{ $subscription->quantity - $subscription->sites_count }}
                                                            sites available)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check form-check-custom form-check-lg">
                                            <input name="type" class="form-check-input" type="radio"
                                                value="transferable" id="radioTransferable"
                                                @if ($subscriptions->count() === 0) checked @endif>
                                            <label class="form-check-label" for="radioTransferable">
                                                {{ __('This site is transferable; it will be moved to someone elses account.') }}
                                                <br />
                                                {{ __('You will be transferring the site to a client or collaborator') }}
                                            </label>
                                        </div>
                                    </div>
                                    <!-- End Site Type -->
                                    <hr />
                                    <!-- Start: Site Creation Way -->
                                    <div class="mb-5">
                                        <h3 class="text-dark mb-8">{{ __('How do you like to start?') }}</h3>
                                        <div class="row">
                                            <div class="col-4">
                                                <!--begin::Option-->
                                                <input type="radio" class="btn-check" name="start" value="blank"
                                                    id="start_blank" checked="true">
                                                <label
                                                    class="btn btn-outline btn-active-light-primary btn-outline-primary p-7 d-flex align-items-center mb-5"
                                                    for="start_blank">
                                                    <span class="d-block fw-bold text-center">
                                                        <span
                                                            class="text-dark fw-bolder d-block fs-3">{{ __('Start with a blank site') }}</span>
                                                        <span class="text-muted fw-bold fs-6">
                                                            {{ __('Add an empty Mautic') }}
                                                        </span>
                                                    </span>
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                            <div class="col-4">
                                                <!--begin::Option-->
                                                <input type="radio" class="btn-check" name="start" value="copyEnv"
                                                    id="start_copy" />
                                                <label
                                                    class="btn btn-outline btn-outline-primary btn-active-light-primary p-7 d-flex align-items-center mb-5"
                                                    for="start_copy">
                                                    <span class="d-block fw-bold text-center">
                                                        <span class="text-dark fw-bold fs-3">
                                                            {{ __('Copy an existing environment to a new Mautic') }}
                                                        </span>
                                                    </span>
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                            <div class="col-4">
                                                <!--begin::Option-->
                                                <input type="radio" class="btn-check" name="start" value="moveEnv"
                                                    id="start_move" />
                                                <label
                                                    class="btn btn-outline btn-outline-primary btn-active-light-primary p-7 d-flex align-items-center mb-5"
                                                    for="start_move">
                                                    <span class="d-block fw-bold text-center">
                                                        <span class="text-dark fw-bold fs-3">
                                                            {{ __('Move an existing environment to a new Mautic') }}
                                                        </span>
                                                    </span>
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="installs d-none">
                                        <hr />
                                        <div class="mt-5">
                                            <h3 class="text-dark">{{ __('Select an Install to use') }}</h3>
                                            <select class="form-select" name="install_id" required>
                                                <option value="" disabled selected>
                                                    {{ __('Please select an install') }}</option>
                                                @foreach ($installs as $install)
                                                    <option value="{{ $install->id }}">{{ $install->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                {{ __('Please select a valid Install.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--begin::Step 1-->

                                <!--begin::Step 2-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    <h3>{{ __('Site name and first environment') }}</h3>
                                    <p>{{ __('A site is a group of up to three environments (Production, Staging, Development) under one name') }}
                                    </p>
                                    <div class="mb-10">
                                        <div class="form-group fv-row">
                                            <label>{{ __('Site Name') }}</label>
                                            <input name="sitename" type="text" class="form-control form-control-solid"
                                                placeholder="{{ __('Site Name') }}" />
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group fv-row">
                                                    <label>{{ __('Environment Name') }}</label>
                                                    <div class="col d-flex gap-3 align-items-center">
                                                        <input name="environmentname" type="text"
                                                            class="w-50 form-control form-control-solid"
                                                            placeholder="{{ __('Environment Name') }}" />
                                                        <p class="m-0">.steercampaign.com</p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div>
                                        <h3>{{ __('Environment type') }}</h3>
                                        <p>{{ __('Create additional environments later from the Site Overview page.') }}
                                        </p>
                                        <label class="d-block">
                                            <!--end::Description-->
                                            <div class="d-flex me-2">
                                                <!--begin::Radio-->
                                                <div class="form-check-custom form-check-solid form-check-primary me-2">
                                                    <input class="form-check-input" type="radio" name="environmenttype"
                                                        value="prd" checked />
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
                                                    <input class="form-check-input" type="radio" name="environmenttype"
                                                        value="stg" />
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
                                                    <input class="form-check-input" type="radio" name="environmenttype"
                                                        value="dev" disabled />
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
                                    </div>
                                </div>
                                <!--begin::Step 2-->
                            </div>
                            <!--end::Group-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Wrapper-->
                                <div>
                                    <a href="{{ route('sites.index', $currentAccount) }}" type="button"
                                        class="btn btn-secondary btn-cancel">
                                        {{ __('Cancel') }}
                                    </a>
                                    <button type="button" class="btn btn-secondary" data-kt-stepper-action="previous">
                                        {{ __('Back') }}
                                    </button>
                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        {{ __('Next') }}
                                    </button>
                                    <button id="btn-submit" type="button" class="btn btn-primary"
                                        data-kt-stepper-action="submit">
                                        <span class="indicator-label">
                                            {{ __('Add site') }}
                                        </span>
                                        <span class="indicator-progress">
                                            {{ __('Please wait...') }} <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                                <!--end::Wrapper-->
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
            .fv-plugins-icon[data-field='environmentname'] {
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

            document.querySelectorAll('[name="type"]').forEach(function(el) {
                el.addEventListener('change', function() {
                    if (el.value === 'mine') {
                        document.querySelector('#subscriptions').classList.remove('d-none');
                    } else {
                        document.querySelector('#subscriptions').classList.add('d-none');
                    }
                })
            })

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            const form = document.getElementById('site-form')
            var validator = FormValidation.formValidation(
                form, {
                    fields: {
                        'sitename': {
                            validators: {
                                notEmpty: {
                                    message: 'Site name is required'
                                },
                                stringLength: {
                                    min: 3,
                                    max: 40,
                                    message: 'Site name should be at least three characters'
                                }
                            }
                        },
                        'environmentname': {
                            validators: {
                                notEmpty: {
                                    message: 'Environment name is required',
                                },
                                stringLength: {
                                    min: 3,
                                    max: 14,
                                    message: '3 to 14 characters'
                                },
                                uri: {
                                    message: 'The environment name should be a valid URL'
                                },
                                remote: {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                            'content'),
                                        'Content-Type': 'application/json'
                                    },
                                    url: '{{ route('sites.store', $currentAccount->id) }}',
                                    data: function() {
                                        return {
                                            environmentname: form.querySelector['[name="environmentname"]'].value,
                                            isValidation: true
                                        }
                                    },
                                    delay: 100,
                                    message: 'Name is not available',
                                }
                            }
                        }
                    },
                    plugins: {
                        trnsformer: new FormValidation.plugins.Transformer({
                            environmentname: {
                                uri: function(field, element, validator) {
                                    var value = element.value;
                                    var uri = 'https://' + value + '.steercampaign.com';
                                    return uri;
                                }
                            }
                        }),
                        trigger: new FormValidation.plugins.Trigger({
                            event: {
                                environmentname: 'blur change'
                            },
                            threshold: {
                                environmentname: 5
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

                            axios.post('{{ route('sites.store', $currentAccount->id) }}', $('#site-form')
                                .serialize())

                            // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            setTimeout(function() {
                                // Remove loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;

                                // Show popup confirmation
                                Swal.fire({
                                    text: "Form has been successfully submitted!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });

                                //form.submit(); // Submit form
                            }, 2000);
                        }
                    });
                }
            });
        </script>
    @endpush
</x-base-layout>
