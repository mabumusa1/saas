@push("scripts")
<script> 

const rdTransferable =  document.querySelector("input[id='radioTransferable']")
const rdMine =  document.querySelector("input[id='radioMine']")
const rdPrd =  document.querySelector("input[id='radioPrd']")
const rdDev =  document.querySelector("input[id='radioDev']")

rdTransferable.addEventListener("change", function(event) {
    if (event.target.checked){
        rdDev.checked = true
        rdPrd.disabled = true
    }
});

rdMine.addEventListener("change", function(event) {
    if (event.target.checked){
        rdPrd.disabled = false
    }
});

const form = document.getElementById("site-form")

var validator = FormValidation.formValidation(
form, {
    fields: {
        "sitename": {
            validators: {
                notEmpty: {
                    message: "Site name is required"
                },
                stringLength: {
                    min: 3,
                    max: 40,
                    message: "Site name should be at least three characters"
                }
            }
        },
        "installname": {
            validators: {
                notEmpty: {
                    message: "Install name is required",
                },
                stringLength: {
                    min: 3,
                    max: 14,
                    message: "3 to 14 characters"
                },
                uri: {
                    message: "The install name should be a valid URL"
                },
                remote: {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector("meta[name='csrf-token']").getAttribute(
                            "content")
                    },
                    url: "{{ route("sites.store", $currentAccount->id) }}",
                    data: function(val) {
                        return {
                            installname: val,
                            isValidation: 1
                        }
                    },
                    message: "Install name is not available",
                }
            }
        }
    },
    plugins: {
        defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
            rowSelector: '.mb-10',
        }),
        trigger: new FormValidation.plugins.Trigger({
            event: 'blur'
        }),
        transformer: new FormValidation.plugins.Transformer({
            installname: {
                uri: function(field, element, validator) {
                    var value = element.value;
                    var uri = "https://" + value + "." + "{{ env("CNAME_DOMAIN") }}";
                    return uri;
                }
            }
        }),
    },
}) 
.on('core.validator.validating', function(e) {
    if (e.field === 'installname' && e.validator === 'remote') {
        document.getElementById('progressBar').style.opacity = '1';
    }
})
.on('core.validator.validated', function(e) {
    if (e.field === 'installname' && e.validator === 'remote') {
        document.getElementById('progressBar').style.opacity = '0';
    }
});



</script>
@endpush
