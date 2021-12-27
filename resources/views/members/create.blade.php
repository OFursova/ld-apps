<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My team') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-gray-50 border rounded-md">
            <x-jet-banner :message="session('error')"></x-jet-banner>
            <div class="mx-auto bg-gray-100">
                <h3 class="text-2xl p-4">Add New Member</h3>
            </div>
            <div class="w-9/12 mx-auto flex flex-col items-center py-4">
                <form action="{{ route('members.store') }}" method="POST"
                      class="flex flex-col justify-between items-center sm:items-start w-4/5">
                    @csrf

                    <div class="flex justify-between mb-4">
                        <x-jet-label for="name" class="text-lg mr-4">Name:</x-jet-label>
                        <x-jet-input class="self-stretch" name="name" id="name" type="text" :value="old('name')" required></x-jet-input>
                    </div>

                    <div class="flex justify-between mb-4">
                        <x-jet-label for="email" class="text-lg mr-4">Email:</x-jet-label>
                        <x-jet-input class="self-stretch" name="email" id="email" type="email" :value="old('email')" required></x-jet-input>
                    </div>

                    <x-buy-button class="mt-4 mb-4 self-center">Invite</x-buy-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

