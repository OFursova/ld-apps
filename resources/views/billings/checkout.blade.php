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
                    <input type="hidden" id="plan-paying-amount" value="{{number_format($subtotal / 100, 2)}}">
                    <input type="hidden" id="tax-percent" value="{{ $taxPercent }}">

                    <div class="flex justify-between my-2">
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-name" class="text-lg mr-4">Name or Company Name:
                            </x-jet-label>
                            <x-jet-input name="billing_details[company_name]" id="billing-details-name" type="text"
                                         required></x-jet-input>
                        </div>
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-address-1" class="text-lg mr-4">Address Line 1:
                            </x-jet-label>
                            <x-jet-input name="billing_details[address_line_1]" id="billing-details-address-1"
                                         type="text" required></x-jet-input>
                        </div>
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-address-2" class="text-lg mr-4">Address Line 2
                                (optional):
                            </x-jet-label>
                            <x-jet-input name="billing_details[address_line_2]" id="billing-details-address-2"
                                         type="text"></x-jet-input>
                        </div>
                    </div>

                    <div class="flex justify-between my-2">
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-country" class="text-lg mr-4">Country:</x-jet-label>
                            <x-select name="billing_details[country_id]" id="billing-details-country" type="text"
                                      required>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-city" class="text-lg mr-4">City:</x-jet-label>
                            <x-jet-input name="billing_details[city]" id="billing-details-city" type="text"
                                         required></x-jet-input>
                        </div>
                        <div class="flex flex-col">
                            <x-jet-label for="billing-details-postcode" class="text-lg mr-4">Postcode:</x-jet-label>
                            <x-jet-input name="billing_details[postcode]" id="billing-details-postcode"
                                         type="number"></x-jet-input>
                        </div>
                    </div>

                    <hr class="bg-gray-200 my-4">

                    <div class="flex my-2">
                        <x-jet-label for="coupon" class="text-lg mr-4">Discount code:</x-jet-label>
                        <x-jet-input name="coupon" id="coupon" type="text"></x-jet-input>
                        <input id="coupon_check" type="button" name="coupon_check" value="Apply code"
                               class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        <div id="coupon_text" class="ml-4 text-gray-400"></div>
                    </div>

                    <div class="flex mt-4 mb-4">
                        <x-jet-label for="card-holder-name" class="text-lg mr-4">Cardholder name</x-jet-label>
                        <x-jet-input class="w-9/12" id="card-holder-name" type="text"></x-jet-input>
                    </div>

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element" class="w-full mt-4 mb-4 border rounded-md"></div>

                    <hr class="bg-gray-200 my-4">

                    <div class="flex flex-col mt-4 mb-4">
                        <p>Subtotal:
                        <span class="font-bold" id="amount_subtotal">${{ number_format($subtotal / 100, 2) }}</span></p>
                        <p>Tax ({{ $taxPercent }}%):
                        <span class="font-bold" id="amount_taxes">${{ number_format($taxAmount / 100, 2) }}</span></p>
                        <p>Total:
                        <span class="font-bold" id="amount_total">${{ number_format($total / 100, 2) }}</span></p>
                    </div>

                    <x-buy-button class="mt-4 mb-4 self-center" id="card-button"
                                  data-secret="{{ $intent->client_secret }}">
                        Pay ${{number_format($total / 100, 2)}}
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
    <x-slot name="customScripts">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function () {
                $('#coupon_check').on('click', function (e) {
                    $('#coupon_text').text('');
                    $.get({
                        url: "{{ route('coupon') }}?coupon_code=" + $('#coupon').val(),
                        contentType: "application/json",
                        dataType: 'json'
                    }).done(function (result) {
                        let plan_paying_amount = $('#plan-paying-amount').val();
                        if (result.error_text) {
                            $('#coupon_text').text(result.error_text);
                        } else {
                            $('#coupon_text').text(result.name);
                            let tax_percent = $('#tax-percent').val();
                            let pay_amount = (plan_paying_amount * (1 - result.percent_off / 100)).toFixed(2);
                            $('#amount_subtotal').text('$' + pay_amount);
                            let tax_amount = (pay_amount * tax_percent / 100).toFixed(2);
                            $('#amount_taxes').text('$' + tax_amount);
                            pay_amount = (parseFloat(pay_amount) + parseFloat(tax_amount)).toFixed(2);
                            $('#amount_total').text('$' + pay_amount);
                            $('#card-button').text('Pay $' + pay_amount);
                        }
                    });
                });
            });
        </script>
    </x-slot>
</x-app-layout>
