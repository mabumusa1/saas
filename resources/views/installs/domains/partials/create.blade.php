<!-- Create Domain Modal -->
<div class="modal fade" tabindex="-1" id="create_domain_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray-200">
                <h5 class="modal-title">{{ __('Add new domain') }}</h5>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                    </span>
                </div>
                <!--end::Close-->
            </div>
            <form method="POST" id="domain-form" class="form" novalidate="novalidate" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="mb-10">
                        <div class="form-group fv-row">
                            <label for="name">{{ __('Domain') }}</label>
                            <input name="name" id="name" type="text" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btn-submit" class="btn btn-primary">{{ __('Add domain') }}</button>
                </div>
            </form>
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
    const form = document.getElementById('domain-form');
    var validator = FormValidation.formValidation(
        form,{
            fields: {
                'name': {
                    validators: {
                        notEmpty: {
                            message: 'Domain name is required'
                        },
                        uri: {
                            message: 'The domain name is not valid'
                        },
                        remote: {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            url: '{{ route('domains.store', [$currentAccount->id, $site->id, $install->id]) }}',
                            data: function(val) {
                                return {
                                    name: val,
                                    isValidation: 1,
                                }
                            },
                            delay: 500,
                            message: 'Name is not available',
                        }
                    }
                },
            },
        plugins: {
            trnsformer: new FormValidation.plugins.Transformer({
                name: {
                    uri: function(field, element, validator) {
                        var value = element.value;
                        var uri = 'https://' + value
                        return uri;
                    }
                }
            }),
            trigger: new FormValidation.plugins.Trigger({
                event: {
                    name: 'blur',
                },
                threshold: {
                    name: 5,
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
        console.log(e);
        const form = document.getElementById('domain-form')
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
