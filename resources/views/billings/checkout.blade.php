<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-9/12 mx-auto flex flex-col items-center">
                <div class="mx-auto">
                    <h3 class="text-2xl mb-4">Subscribe to {{$plan->name}}</h3>
                </div>

                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form"
                      class="flex flex-col justify-between items-center">
                    @csrf
                    <input type="hidden" name="billing_plan_id" value="{{$plan->id}}">
                    <input type="hidden" name="payment_method" id="payment_method" value="">

                    <x-jet-input id="card-holder-name" type="text"></x-jet-input>

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>

                    <x-jet-button class="mt-4 mb-4" id="card-button" data-secret="{{ $intent->client_secret }}">
                        Pay ${{number_format($plan->price / 100, 2)}}
                    </x-jet-button>
                </form>

            </div>
        </div>
    </div>

    <x-slot name="stripeScripts">
        <script src="https://js.stripe.com/v3/"></script>

        <script>
            const stripe = Stripe("{{env('STRIPE_KEY')}}");

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            const checkoutForm = document.getElementById('checkout-form');
            const paymentMethodInput = document.getElementById('payment_method');
            let paymentMethod = null;

            checkoutForm.addEventListener('submit', async (e) => {
                if (paymentMethod) {
                    return true
                }

                const {setupIntent, error} = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {name: cardHolderName.value}
                        }
                    }
                );

                if (error) {
                    // Display "error.message" to the user...
                    console.log(error)
                    alert('error')
                } else {
                    // The card has been verified successfully...
                    console.log(setupIntent)
                    paymentMethod = setupIntent.payment_method
                    paymentMethodInput.val(paymentMethod)
                    checkoutForm.submit()
                }
            });
        </script>
    </x-slot>
</x-app-layout>
