<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto bg-gray-50 border rounded-md">
            <x-jet-banner :message="session('error')"></x-jet-banner>
            <div class="mx-auto bg-gray-100">
                <h3 class="text-2xl p-4">Subscribe to {{$plan->name}}</h3>
            </div>

            <div class="p-6 mx-auto flex flex-col items-center mt-4">
                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form"
                      class="flex flex-col justify-between w-4/5">
                    @csrf
                    <input type="hidden" name="billing_plan_id" value="{{$plan->id}}">
                    <input type="hidden" name="payment_method" id="payment_method" value="">

                    <div class="flex justify-between my-2">
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-name" class="text-lg mr-4">Name or Company Name:</x-jet-label>
                            <x-jet-input name="billing_details[company_name]" id="billing-details-name" type="text" required></x-jet-input>
                        </div>
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-address-1" class="text-lg mr-4">Address Line 1:</x-jet-label>
                            <x-jet-input name="billing_details[address_line_1]" id="billing-details-address-1" type="text" required></x-jet-input>
                        </div>
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-address-2" class="text-lg mr-4">Address Line 2 (optional):</x-jet-label>
                            <x-jet-input name="billing_details[address_line_2]" id="billing-details-address-2" type="text"></x-jet-input>
                        </div>
                    </div>

                    <div class="flex justify-between my-2">
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-country" class="text-lg mr-4">Country:</x-jet-label>
                            <x-select name="billing_details[country_id]" id="billing-details-country" type="text" required>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-city" class="text-lg mr-4">City:</x-jet-label>
                            <x-jet-input name="billing_details[city]" id="billing-details-city" type="text" required></x-jet-input>
                        </div>
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-postcode" class="text-lg mr-4">Postcode:</x-jet-label>
                            <x-jet-input name="billing_details[postcode]" id="billing-details-postcode" type="text"></x-jet-input>
                        </div>
                    </div>

                    <div class="flex mt-4 mb-4">
                    <x-jet-label for="card-holder-name" class="text-lg mr-4">Cardholder name</x-jet-label>
                    <x-jet-input class="w-9/12" id="card-holder-name" type="text"></x-jet-input>
                    </div>

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element" class="w-full mt-4 mb-4 border rounded-md"></div>

                    <x-buy-button class="mt-4 mb-4 self-center" id="card-button" data-secret="{{ $intent->client_secret }}">
                        Pay ${{number_format($plan->price / 100, 2)}}
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
