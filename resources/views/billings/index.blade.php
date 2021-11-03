<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Billing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-jet-banner :message="session('message')"></x-jet-banner>
            <div class="flex justify-between">
                @foreach($plans as $plan)
                    <div class="max-w-2xl mx-auto p-4 border-2 rounded flex flex-col justify-center items-center">
                        <h3 class="text-2xl text-indigo-600 font-bold">{{$plan->name}}</h3>
                        <b>${{number_format($plan->price / 100, 2)}} / month</b>
                        <x-jet-button class="mt-4 mb-4"><a href="{{ route('checkout', $plan->id) }}">{{ __("Subscribe to {$plan->name}") }}</a>
                        </x-jet-button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
