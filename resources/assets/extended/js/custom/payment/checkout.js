var exceeder = {};
document.querySelector('[data-kt-buttons="true"]').children.forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();
        e.target.getAttribute('data-kt-plan')
        document.querySelectorAll('[data-kt-element="price"]').forEach(function (el) {
            el.textContent = el.getAttribute('data-kt-plan-price-' + e.target.getAttribute(
                'data-kt-plan'));
            el.parentElement.querySelector('[data-kt-element="period"]').textContent = e
                .target.getAttribute('data-kt-plan')[0].toUpperCase() + e.target
                .getAttribute('data-kt-plan').substring(1, 3)
        })
    })
})


document.querySelectorAll('.purchase-button').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
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
            'account': {
                {
                    $currentAccount - > id
                }
            },
            'plan': planId,
            'options': {
                'annual': isAnnual,
                'quantity': quantity
            }
        }).then(function (res) {
            location.href = res.data.link.url;
        }).catch(function (err) {
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

        }).finally(function () {
            btn.parentElement.parentElement.parentElement.classList.remove('overlay-block');
            btn.parentElement.parentElement.parentElement.querySelector('.overlay-layer')
                .classList.add('d-none');
        });
    })
})

var plans = {
    !!json_encode($plans) !!
};

function createSliderValues(values) {
    const steps = 100 / values.length;
    let sliderValues = {};
    values.forEach(function (value, index) {
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
        to: function (value) {
            var formatter = new Intl.NumberFormat('en-US')
            if (value == exceeder.value) {
                return '> ' + formatter.format(exceeder.label);
            } else {
                return formatter.format(value);
            }
        }
    }],
    connect: true,
    range: createSliderValues(plans.map(function (plan) {
        return plan.contacts
    }))
});

function formatTooltip(values) {
    console.log(values)
}

slider.noUiSlider.on("update", function (values, handle) {
    var plan = plans.find(function (plan) {
        return plan.contacts == values[handle];
    });
    var price = document.querySelector('[data-kt-element="price"]');
    var purchaseButton = document.querySelector('.purchase-button');
    if (plan) {
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
