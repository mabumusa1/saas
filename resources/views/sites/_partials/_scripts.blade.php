@push("scripts")
<script> 
document.addEventListener("DOMContentLoaded", () => {
  const rdTransferable =  document.querySelector("input[id='radioTransferable']")
  const rdMine =  document.querySelector("input[id='radioMine']")
  const rdPrd =  document.querySelector("input[id='radioPrd']")
  const rdDev =  document.querySelector("input[id='radioDev']")
  const billingDiv = document.getElementById("billingDiv")

    rdTransferable.addEventListener("change", function(event) {
        if (event.target.checked){
            rdDev.checked = true
            rdPrd.disabled = true
            billingDiv.classList.add('d-none')
        }
    });

    rdMine.addEventListener("change", function(event) {
        if (event.target.checked){
            rdPrd.disabled = false
            rdPrd.checked = true
            billingDiv.classList.remove('d-none')
        }
    });
    // add the features to the plan
    const selectContacts = document.getElementById('planId');
    const planFeatures = document.querySelector('#features')
    document.getElementById("planId").addEventListener("change", (event) => {
        const planId = event.target.value
        var plan = plans.find(el => el.id == planId)
        document.getElementById('planTitle').innerHTML = plan.display_name
        document.getElementById('planDescription').innerHTML = plan.short_description
        document.getElementById('priceSpan').setAttribute('data-kt-plan-price-month', plan.monthly_price)
        document.getElementById('priceSpan').setAttribute('data-kt-plan-price-annual', plan.yearly_price)
        document.getElementById('priceSpan').innerHTML = plan.monthly_price
        document.querySelector('[data-kt-plan="month"]').click()
        planFeatures.innerHTML = ""
        plan.features.forEach((feature, index) => {
            const item = document.createElement('span')
            item.className = 'fw-bold fs-6 text-gray-800 flex-grow-1 pe-3'
            item.id = `feature-${index}`,
            item.innerHTML = feature
            const icon = document.createElement('span')
            icon.className = 'svg-icon svg-icon-1 svg-icon-success'
            icon.innerHTML = `{!! get_svg_icon('icons/duotune/general/gen043.svg') !!}`
            planFeatures.appendChild(icon) 
            planFeatures.appendChild(item)
        })    
    });
    plans.forEach((plan, index) => {
        selectContacts.options.add(new Option(plan.contacts, plan.id))
        if(index === 0 ){
            selectContacts.value = plan.id
            selectContacts.dispatchEvent(new Event("change"));

        }
    });


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
                }
            }
        }
    },
    plugins: {
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
                    var uri = `https://${value}.{{ env("CNAME_DOMAIN") }}`;
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

// Submit button handler
const submitButton = document.getElementById('btn-submit');
submitButton.addEventListener('click', function(e) {
    const form = document.getElementById('site-form')
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

var KTPricingGeneral = function() {
    var n, t, e, a = function(t) {
        [].slice.call(document.querySelector('#plan_price').querySelectorAll("[data-kt-plan-price-month]"))
            .map((function(n) {
                var e = n.getAttribute("data-kt-plan-price-month"),
                    a = n.getAttribute("data-kt-plan-price-annual");
                "month" === t ? n.innerHTML = e : "annual" === t && (n.innerHTML = a)
            }))
    };
    return {
        init: function() {
            var planPeroid = document.querySelector('#plan_peroid')
            n = document.querySelector("#kt_pricing"), t = n.querySelector('[data-kt-plan="month"]'), e = n
                .querySelector('[data-kt-plan="annual"]'), t.addEventListener("click", (function(n) {
                    n.preventDefault(), a("month"), planPeroid.value = "month", planPeroid.value =
                        "month"
                })), e.addEventListener("click", (function(n) {
                    n.preventDefault(), a("annual"), planPeroid.value = "year"
                }))
        }
    }
}();
KTUtil.onDOMContentLoaded((function() {
    KTPricingGeneral.init()
}));
</script>
@endpush
