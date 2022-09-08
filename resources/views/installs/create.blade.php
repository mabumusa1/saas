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
                            action="{{ route('installs.store', ['account' => $currentAccount, 'site' => $site]) }}"
                            id="install-form" class="form mx-auto" novalidate="novalidate" autocomplete="off">
                            @csrf
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
                                                        <p class="m-0">.{{env('CNAME_DOMAIN')}}</p>
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
                                            @foreach ($envs as $env )
                                            @switch($env)
                                                @case('prd')
                                                    <label class="d-block">
                                                        <div class="d-flex me-2">
                                                            <div class="form-check-custom form-check-solid form-check-primary me-2">
                                                                <input name="type" class="form-check-input" type="radio" value="prd"
                                                                    @if ($selectedEnv === 'prd') checked @endif />
                                                            </div>
                                                            <div class="ms-2">
                                                                {!! get_svg_icon('skin/media/icons/duotone/Communication/Share.svg') !!}
                                                                <div class="badge badge-primary ms-2">{{ __('PRD') }}</div>
                                                                <div class="d-flex d-inline-flex flex-column">
                                                                    <p class="mb-0">{{ __('Production (live)') }}</p>
                                                                    <p>{{ __('Host a public site') }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>                                                                
                                                    @break

                                                
                                                @case('dev')
                                                <label class="d-block">
                                                    <!--end::Description-->
                                                    <div class="d-flex me-2">
                                                        <!--begin::Radio-->
                                                        <div class="form-check-custom form-check-solid form-check-primary me-2">
                                                            <input name="type" class="form-check-input" type="radio" value="dev"
                                                                @if ($selectedEnv === 'dev') checked @endif />
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
                                                                                                    
                                                    @break
                                                    
                                            @endswitch
                                            @endforeach
                                            
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
            .fv-plugins-icon[data-field='name'] {
                top: 22px !important;
            }

        </style>
    @endpush
    @push('scripts')
        <script>
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
                                },
                                uri: {
                                    message: 'The install name should be a valid URL'
                                },
                                remote: {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    },
                                    url: '{{ route('installs.store', [$currentAccount->id, $site->id]) }}',
                                    data: function(val) {
                                        return {
                                            name: val,
                                            isValidation: 1,
                                            type: document.querySelector('input[name="type"]').value
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
                            name: {
                                uri: function(field, element, validator) {
                                    var value = element.value;
                                    var uri = 'https://' + value + '.' {{env('CNAME_DOMAIN')}};
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
                const form = document.getElementById('install-form')
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
