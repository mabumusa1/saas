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
                                        <div class="form-check form-check-custom form-check-solid form-check-lg">
                                            <input name="type" class="form-check-input" type="radio" value="mine"
                                                id="radioMine" @if (!$subscriptions->count()) disabled @endif>
                                            <label class="form-check-label" for="radioMine">
                                                {{ __('This site is mine; it will count towards my site allowance') }}
                                                <br />
                                                You have {{ $subscriptions->sum('quantity') - $subscriptions->sum('sites_count') }} of {{ $count }} sites available. @if(!$subscriptions->count()) Delete site or <a href="{{ route('billing.index', [$account]) }}">Upgrade your
                                                    plan</a> @endif
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-10 d-none" id="subscriptions">
                                        <div class="form-group">
                                            <select name="subscription_id" id="subscription_id" class="form-control">
                                                @foreach ($subscriptions as $subscription)
                                                    <option value="{{ $subscription->id }}"
                                                        @if ($subscription->id == $account->subscription_id) selected @endif>
                                                        {{ $subscription->name }}
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
                                        <div class="form-check form-check-custom form-check-solid form-check-lg">
                                            <input name="type" class="form-check-input" type="radio"
                                                value="transferable" id="radioTransferable">
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
                                                        <span class="text-dark fw-bolder d-block fs-3">Start with a
                                                            blank site</span>
                                                        <span class="text-muted fw-bold fs-6">
                                                            Add an empty WordPress ite pre-installed with a (removable)
                                                            lightweight Genesis theme.
                                                        </span>
                                                    </span>
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                            <div class="col-4">
                                                <!--begin::Option-->
                                                <input type="radio" class="btn-check" name="start" value="guided"
                                                    id="start_guided" />
                                                <label
                                                    class="btn btn-outline btn-outline-primary btn-active-light-primary p-7 d-flex align-items-center mb-5"
                                                    for="start_guided">
                                                    <span class="d-block fw-bold text-center">
                                                        <span class="text-dark fw-bolder d-block fs-3">Start with a
                                                            guided experience</span>
                                                        <span class="text-muted fw-bold fs-6">
                                                            Get up and running faster with sites building tools and
                                                            sample content
                                                        </span>
                                                    </span>
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                            <div class="col-4 d-flex">
                                                <!--begin::Option-->
                                                <input type="radio" class="btn-check" name="start" value="migrate"
                                                    id="start_migrate" />
                                                <label
                                                    class="btn btn-outline btn-outline-primary btn-active-light-primary p-7 d-flex align-items-center mb-5 justify-content-center w-100"
                                                    for="start_migrate">
                                                    <span class="d-block fw-bold text-center">
                                                        <span
                                                            class="text-center text-dark fw-bolder d-block fs-3">Migrate
                                                            a site</span>
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
                                                        <span class="text-dark fw-bold fs-3">Copy an existing
                                                            environment to a new site</span>
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
                                                        <span class="text-dark fw-bold fs-3">Move an existing
                                                            environment to a new site</span>
                                                    </span>
                                                </label>
                                                <!--end::Option-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="installs d-none">
                                        <hr />
                                        <div class="mt-5">
                                            <h3 class="text-dark">{{ __('Select Install to use') }}</h3>
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
                                            {{-- <span class="form-text text-muted">Site name is unique</span> --}}
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
                                                    {{-- <span class="form-text text-muted">Enviroment name is unique</span> --}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div>
                                        <h3>{{ __('Environment type') }}</h3>
                                        <p>{{ __('Create additional environments later from the Site Overview page.') }}</p>
                                        <label class="d-block">
                                            <!--end::Description-->
                                            <div class="d-flex me-2">
                                                <!--begin::Radio-->
                                                <div
                                                    class="form-check-custom form-check-solid form-check-primary me-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="environmenttype" value="prd" />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Price-->
                                                <div class="ms-2">
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                        version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z"
                                                            id="Path-57" fill="#000000" fill-rule="nonzero"
                                                            opacity="0.3"></path>
                                                        <path
                                                            d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z"
                                                            id="Shape" fill="#000000" fill-rule="nonzero"
                                                            transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) ">
                                                        </path>
                                                    </svg>
                                                    <div class="badge badge-primary ms-2">PRD</div>
                                                    <div class="d-flex d-inline-flex flex-column">
                                                        <p class="mb-0">Prduction (live)</p>
                                                        <p>Host a public site</p>
                                                    </div>
                                                </div>
                                                <!--end::Price-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                        <label>
                                            <!--end::Description-->
                                            <div class="d-flex me-2">
                                                <!--begin::Radio-->
                                                <div
                                                    class="form-check-custom form-check-solid form-check-primary me-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="environmenttype" value="stg" />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Price-->
                                                <div class="ms-2">
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                        version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z"
                                                            id="Path-57" fill="#000000" fill-rule="nonzero"
                                                            opacity="0.3"></path>
                                                        <path
                                                            d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z"
                                                            id="Shape" fill="#000000" fill-rule="nonzero"
                                                            transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) ">
                                                        </path>
                                                    </svg>
                                                    <div class="badge badge-light-primary ms-2">STG</div>
                                                    <div class="d-flex d-inline-flex flex-column">
                                                        <p class="mb-0">Staging (optional sandbox)</p>
                                                        <p>Review and test before deploying to Production.</p>
                                                    </div>
                                                </div>
                                                <!--end::Price-->
                                            </div>
                                            <!--end::Description-->
                                        </label>
                                        <label>
                                            <!--end::Description-->
                                            <div class="d-flex me-2">
                                                <!--begin::Radio-->
                                                <div
                                                    class="form-check-custom form-check-solid form-check-primary me-2">
                                                    <input class="form-check-input" type="radio"
                                                        name="environmenttype" value="dev" />
                                                </div>
                                                <!--end::Radio-->

                                                <!--begin::Price-->
                                                <div class="ms-2">
                                                    <svg width="24px" height="24px" viewBox="0 0 24 24"
                                                        version="1.1" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M10.9,2 C11.4522847,2 11.9,2.44771525 11.9,3 C11.9,3.55228475 11.4522847,4 10.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,16 C20,15.4477153 20.4477153,15 21,15 C21.5522847,15 22,15.4477153 22,16 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L10.9,2 Z"
                                                            id="Path-57" fill="#000000" fill-rule="nonzero"
                                                            opacity="0.3"></path>
                                                        <path
                                                            d="M24.0690576,13.8973499 C24.0690576,13.1346331 24.2324969,10.1246259 21.8580869,7.73659596 C20.2600137,6.12944276 17.8683518,5.85068794 15.0081639,5.72356847 L15.0081639,1.83791555 C15.0081639,1.42370199 14.6723775,1.08791555 14.2581639,1.08791555 C14.0718537,1.08791555 13.892213,1.15726043 13.7542266,1.28244533 L7.24606818,7.18681951 C6.93929045,7.46513642 6.9162184,7.93944934 7.1945353,8.24622707 C7.20914339,8.26232899 7.22444472,8.27778811 7.24039592,8.29256062 L13.7485543,14.3198102 C14.0524605,14.6012598 14.5269852,14.5830551 14.8084348,14.2791489 C14.9368329,14.140506 15.0081639,13.9585047 15.0081639,13.7695393 L15.0081639,9.90761477 C16.8241562,9.95755456 18.1177196,10.0730665 19.2929978,10.4469645 C20.9778605,10.9829796 22.2816185,12.4994368 23.2042718,14.996336 L23.2043032,14.9963244 C23.313119,15.2908036 23.5938372,15.4863432 23.9077781,15.4863432 L24.0735976,15.4863432 C24.0735976,15.0278051 24.0690576,14.3014082 24.0690576,13.8973499 Z"
                                                            id="Shape" fill="#000000" fill-rule="nonzero"
                                                            transform="translate(15.536799, 8.287129) scale(-1, 1) translate(-15.536799, -8.287129) ">
                                                        </path>
                                                    </svg>
                                                    <div class="badge border border-1 border-primary text-primary ms-2">DEV</div>
                                                    <div class="d-flex d-inline-flex flex-column">
                                                        <p class="mb-0">Development (optional sandbox)</p>
                                                        <p>Build and experiment before deploying to Staging or Production.</p>
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
                                    <a href="{{ route('sites.index', $currentAccount) }}" type="button" class="btn btn-light btn-light-primary btn-cancel">
                                        {{ __('Cancel') }}
                                    </a>
                                    <button type="button" class="btn btn-light btn-active-light-primary"
                                        data-kt-stepper-action="previous">
                                        {{ __('Back') }}
                                    </button>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Wrapper-->
                                <div>
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

                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        {{ __('Next') }}
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

    @push('scripts')
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

                // if (['copyEnv', 'moveEnv'].includes(document.querySelector('[name="start"]:checked').value) && !
                // installId.value) {
                // installId.classList.add('is-invalid');
                // } else {
                stepper.goNext();
                document.querySelector('.btn-cancel').classList.add('d-none');
                // }
            });

            // Handle previous step
            stepper.on("kt.stepper.previous", function(stepper) {
                stepper.goPrevious(); // go previous step
                document.querySelector('.btn-cancel').classList.remove('d-none');
            });

            // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
            var validator = FormValidation.formValidation(
                document.getElementById('site-form'), {
                    fields: {
                        'sitename': {
                            validators: {
                                notEmpty: {
                                    message: 'Site name is required'
                                },
                                stringLength: {
                                    min: 1,
                                    max: 40,
                                    message: '1 to 40 characters'
                                },
                                remote: {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $("input[name='_token']").val(),
                                    },
                                    url: '/1/form-validation',
                                    message: 'Site name is unique',
                                }
                            }
                        },
                        'environmentname': {
                            validators: {
                                notEmpty: {
                                    message: 'Environment is required',
                                },
                                stringLength: {
                                    min: 3,
                                    max: 14,
                                    message: '3 to 14 characters'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z0-9]*$/i,
                                    message: 'Only letters and numbers'
                                },
                                remote: {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $("input[name='_token']").val(),
                                    },
                                    url: '/1/form-validation',
                                    message: 'Name is available',
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
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
                        console.log(validator);

                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;

                            axios.post('{{ route('sites.store', $account->id) }}', $('#site-form')
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

            document.querySelectorAll('[name="type"]').forEach(function(el) {
                el.addEventListener('change', function() {
                    if (el.value === 'mine') {
                        document.querySelector('#subscriptions').classList.remove('d-none');
                    } else {
                        document.querySelector('#subscriptions').classList.add('d-none');
                    }
                })
            })
            // $(document).ready(function() {
            //     $('#btn-submit').click(function (e) {
            //
            //         $('#btn-submit').attr("data-kt-indicator","on");
            //         e.preventDefault();
            //
            //         var _token = $("input[name='_token']").val();
            //         var type = $("input[name='type']:checked").val();
            //         var start = $("input[name='start']:checked").val();
            //         var sitename = $("input[name='sitename']").val();
            //         var environmentname = $("input[name='environmentname']").val();
            //         var environment = $("input[name='environment']").val();
            //
            //         axios.post('/form-validation', {
            //                 type: type,
            //                 start: start,
            //                 sitename: sitename,
            //                 environmentname: environmentname,
            //                 environment: environment
            //             },
            //             {
            //                 headers: {
            //                     'Content-Type': 'application/json',
            //                     'X-CSRF-TOKEN': _token,
            //                     'X-Requested-With': 'XMLHttpRequest',
            //                 }
            //             }).then(function(response){
            //                 $('#btn-submit').attr("data-kt-indicator","off");
            //         }).catch(function(error){
            //             $('#btn-submit').attr("data-kt-indicator","off")
            //             console.log(error.response.data.errors)
            //             var err = error.response.data.errors;
            //             if('sitename' in err){
            //                 $('#siteerr').addClass('text-danger');
            //                 $('#siteerr').removeClass('text-muted');
            //                 $('#siteerr').text(err['sitename']);
            //             }if('environmentname' in err){
            //                 $('#enverr').addClass('text-danger');
            //                 $('#enverr').removeClass('text-muted');
            //                 $('#enverr').text(err['environmentname']);
            //             }
            //
            //         })
            //     });
            // });
        </script>
    @endpush
</x-base-layout>
