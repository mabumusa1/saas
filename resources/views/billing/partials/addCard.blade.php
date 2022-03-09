<div class="mb-10">
    <label for="card-element" class="required form-label">{{ __('Card information') }}</label>
    <div id="card-element" class="form-control" style="height:3em"></div>
</div>    
<div id="card-element-error" class="mt-2 mb-5 text-red" role="alert"></div>
<div class="d-flex justify-content-end">
    <button id="card-button" type="submit" class="btn btn-primary" data-secret="{{ $intent->client_secret }}">
        <span class="indicator-label">
            {{__('Save payment method')}}
        </span>
        <span class="indicator-progress">
            {{__('Please wait...')}} <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
        </span>
    </button>
</div>
@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
const stripe = Stripe('{{env('STRIPE_KEY')}}');
const elements = stripe.elements();
const cardElement = elements.create('card', {hidePostalCode: true})
const billingEmail = document.getElementById('billing-email');
const billingName = document.getElementById('billing-name');
const cardButton = document.getElementById('card-button');
const errorHandler = document.getElementById('card-element-error');
const clientSecret = cardButton.dataset.secret;
const cardElementError = document.getElementById('card-element-error');
cardElement.mount('#card-element');    

cardElement.on('change', function (event) {
    if (event.error) {
        cardElementError.innerHTML = `
            <span><i class="fas fa-exclamation-circle text-danger"></i></span>
            <span class="text-danger">${event.error.message}</span>`;
    } else {
        cardElementError.textContent = " ";
    }
});

cardButton.addEventListener('click', async (event) => {
    event.preventDefault();
    cardElement.update({
        'disabled': true
    });    
    cardButton.disabled = true;
    cardButton.setAttribute("data-kt-indicator", "on");

    const { setupIntent, error } = await stripe.confirmCardSetup(
        clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: { 
                    name: billingName.value,
                    email: billingEmail.value
                }
            }
        }
    );
    
    if (error) {
        cardElementError.innerHTML = `
            <span><i class="fas fa-exclamation-circle text-danger"></i></span>
            <span class="text-danger">${error.message}</span>`;
        cardElement.update({
            'disabled': false
        });    
        cardButton.disabled = false;
        cardButton.removeAttribute("data-kt-indicator");
    } else {
        axios.put('{{route("billing.update", $currentAccount->id)}}', {payment_method: setupIntent.payment_method}, {headers: {'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')}})
        .then(function(data){
            errorHandler.textContent = "";
            location.reload();
        }).catch(function(error){
            cardElementError.innerHTML = `
            <span><i class="fas fa-exclamation-circle text-danger"></i></span>
            <span class="text-danger">${error.message}</span>`;
            cardElement.update({
                'disabled': false
            });    
            cardButton.disabled = false;
            cardButton.removeAttribute("data-kt-indicator");

        });
    }
});    
</script>
@endpush