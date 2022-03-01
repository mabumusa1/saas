<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <input id="card-holder-name" type="text">

    <!-- Stripe Elements Placeholder -->
    <div id="card-element"></div>

    <button id="card-button" data-secret="{{ $intent->client_secret }}">
        Update Payment Method
    </button>

    {{-- begin::Javascript --}}
@if (theme()->hasOption('assets', 'js'))
{{-- begin::Global Javascript Bundle(used by all pages) --}}
@foreach (array_unique(theme()->getOption('assets', 'js')) as $file)
    <script src="{{ asset(theme()->getDemo() . '/' .$file) }}"></script>
@endforeach
{{-- end::Global Javascript Bundle --}}
@endif

@if (theme()->hasOption('page', 'assets/vendors/js'))
{{-- begin::Page Vendors Javascript(used by this page) --}}
@foreach (array_unique(theme()->getOption('page', 'assets/vendors/js')) as $file)
    <script src="{{ asset(theme()->getDemo() . '/' .$file) }}"></script>
@endforeach
{{-- end::Page Vendors Javascript --}}
@endif

@if (theme()->hasOption('page', 'assets/custom/js'))
{{-- begin::Page Custom Javascript(used by this page) --}}
@foreach (array_unique(theme()->getOption('page', 'assets/custom/js')) as $file)
    <script src="{{ asset(theme()->getDemo() . '/' .$file) }}"></script>
@endforeach
{{-- end::Page Custom Javascript --}}
@endif
{{-- end::Javascript --}}
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe(
            'pk_test_51KY8wAJJANQIX4AvfvOhK9r1X40Wdzh2EXopxzcyHbwylMgKBpEHKtJhloE93u8CGoaz7IOnihxBCAr4skqwhM0N00aKqlXsoK'
        );

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod(
                'card', cardElement, {
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            );
            if (error) {
                // Display "error.message" to the user...
            } else {
                axios.post('add_payment_method', {
                    id: paymentMethod.id,
                })

            }
        });
    </script>
</body>

</html>
