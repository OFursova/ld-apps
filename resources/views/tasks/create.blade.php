<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-gray-50 border rounded-md">
            <x-jet-banner :message="session('error')"></x-jet-banner>
            <div class="mx-auto bg-gray-100">
                <h3 class="text-2xl p-4">Add New Task</h3>
            </div>
            <div class="w-9/12 mx-auto flex flex-col items-center py-4">
                <form action="{{ route('tasks.store') }}" method="POST"
                      class="flex flex-col justify-between sm:items-start w-4/5">
                    @csrf

                    <div class="flex justify-between">
                        <x-jet-label for="task-name" class="text-lg mr-4">Task name:</x-jet-label>
                        <x-jet-input class="self-stretch" name="name" id="task-name" type="text" required></x-jet-input>
                    </div>

                    <x-buy-button class="mt-4 mb-4 self-center">Save</x-buy-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

