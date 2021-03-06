<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-gray-50 border rounded-md">
            <x-jet-banner :message="session('error')"></x-jet-banner>
            <div class="mx-auto bg-gray-100">
                <h3 class="text-2xl p-4">Add Payment Method</h3>
            </div>
            <div class="w-9/12 mx-auto flex flex-col items-center py-4">
                <form action="{{ route('payment-methods.store') }}" method="POST" id="checkout-form"
                      class="flex flex-col justify-between sm:items-start w-4/5">
                    @csrf
                    <input type="hidden" name="payment_method" id="payment_method" value="">

                    <div class="flex justify-between">
                    <x-jet-label for="card-holder-name" class="text-lg mr-4">Card holder name</x-jet-label>
                    <x-jet-input class="self-stretch" id="card-holder-name" type="text"></x-jet-input>
                    </div>

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element" class="w-full mt-4 mb-4 border rounded-md shadow-sm"></div>

                    <div><input class="mr-4 rounded" type="checkbox" name="default" value="1">Mark as Default Method</div>

                    <x-buy-button class="mt-4 mb-4 self-center" id="card-button" data-secret="{{ $intent->client_secret }}">
                        Add Method
                    </x-buy-button>
                </form>
            </div>
        </div>
    </div>

    <x-slot name="stripeScripts">
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe("{{env('STRIPE_KEY')}}");

            let style = {
                base: {
                    color: '#31325f',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    },
                    iconColor: "#666ee8",
                    lineHeight: "40px",
                    backgroundColor: "#fff",
                    padding: "5px",
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }

            const elements = stripe.elements();
            const cardElement = elements.create('card', {style: style});

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            const checkoutForm = document.getElementById('checkout-form');
            let paymentMethod = null;

            checkoutForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                if (paymentMethod) {
                    return true
                }
                stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {name: cardHolderName.value}
                        }
                    }
                ).then(function (result) {
                    if (result.error) {
                        // Display "error.message" to the user...
                        console.log(result.error)
                        alert('error')
                    } else {
                        // The card has been verified successfully...
                        paymentMethod = result.setupIntent.payment_method;
                        document.getElementById('payment_method').value = paymentMethod;
                        checkoutForm.submit()
                    }
                });
            });
        </script>
    </x-slot>
</x-app-layout>
