<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-jet-banner :message="session('message')"></x-jet-banner>
            @if (is_null($currentPlan))
                <p class="text-center mb-4 text-gray-400 text-lg">You are now on Free Plan. Please choose plan to upgrade:</p>
            @elseif ($currentPlan->trial_ends_at)
                <p class="text-center mb-4 text-gray-400 text-lg">Your trial will end on {{ $currentPlan->trial_ends_at->toDateString() }} and your card will be charged.</p>
            @endif
            <div class="flex justify-between">
                @foreach($plans as $plan)
                    <div
                        class="max-w-2xl mx-auto p-4 border-2 rounded flex flex-col justify-center items-center bg-gray-50">
                        <h3 class="text-2xl text-indigo-600 font-bold">{{$plan->name}}</h3>
                        <b>${{number_format($plan->price / 100, 2)}} / month</b>
                        @if (!is_null($currentPlan) && $plan->stripe_price_id == $currentPlan->stripe_price)
                            <p class="mt-4 mb-4">Your current plan</p>
                            @if ($currentPlan->onGracePeriod())
                                <p class="text-center">Your subscribtion will end
                                    on {{ $currentPlan->ends_at->toDateString() }}</p>
                                <x-jet-button class="mt-2"><a
                                        href="{{ route('resume') }}">{{ __("Resume subscription") }}</a>
                                </x-jet-button>
                            @else
                                <x-jet-button class="bg-rose-600" onclick="return confirm('Are you sure?')"><a
                                        href="{{ route('cancel') }}">{{ __("Cancel plan") }}</a>
                                </x-jet-button>
                            @endif
                        @else
                            <x-jet-button class="mt-4 mb-4"><a
                                    href="{{ route('checkout', $plan->id) }}">{{ __("Subscribe to {$plan->name}") }}</a>
                            </x-jet-button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        @if (!is_null($currentPlan))
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <x-jet-banner :message="session('message')"></x-jet-banner>

                <h3 class="mb-4 mt-8 text-2xl text-indigo-500">Payment methods</h3>

                <table class="w-full whitespace-no-wrap w-full whitespace-no-wrap bg-gray-50">
                    <thead>
                    <tr class="font-bold bg-gray-100">
                        <th class="w-1/4 border px-6 py-4">Brand</th>
                        <th class="w-1/2 border px-6 py-4">Expires at</th>
                        <th class="w-1/4 border px-1 py-4"></th>
                    </tr>
                    </thead>
                    @foreach($paymentMethods as $paymentMethod)
                        <tr>
                            <td class="border px-6 py-4">{{$paymentMethod->card->brand}}</td>
                            <td class="border px-6 py-4">{{$paymentMethod->card->exp_month}}
                                / {{$paymentMethod->card->exp_year}}</td>
                            <td class="border px-1 py-4 text-center">
                                @if ($defaultPaymentMethod->id == $paymentMethod->id)
                                    <span class="text-indigo-700 font-bold">Default</span>
                                @else
                                    <a href="{{ route('payment-methods.markDefault',  $paymentMethod->id) }}">Mark as
                                        default</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
                <x-jet-button class="mt-4 mb-4"><a
                        href="{{ route('payment-methods.create') }}">{{ __("Add payment method") }}</a>
                </x-jet-button>
            </div>
        @endif
    </div>
</x-app-layout>
