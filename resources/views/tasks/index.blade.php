<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-jet-banner :message="session('message')"></x-jet-banner>

            <h3 class="mb-4 mt-8 text-2xl text-indigo-500">My Tasks</h3>

            @can('tasks_create')
                <x-jet-button class="mt-4 mb-4">
                    <a href="{{ route('tasks.create') }}">{{ __("Add new task") }}</a>
                </x-jet-button>
            @else
                You have reached the limit of your plan. Please <a href="{{ route('billings.index') }}">Upgrade your
                    plan</a>.
            @endcan

            <table class="w-full whitespace-no-wrap w-full whitespace-no-wrap bg-gray-50">
                <thead>
                <tr class="font-bold bg-gray-100">
                    <th class="border px-6 py-4">Task</th>
                    <th class="border px-1 py-4"></th>
                </tr>
                </thead>
                @forelse ($tasks as $task)
                    <tr>
                        <td class="border px-6 py-4">{{ $task->name }}</td>
                        <td class="border px-1 py-4 text-center">
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                @csrf
                                <x-buy-button class="mt-4 mb-4 self-center bg-red-600">Delete</x-buy-button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">No tasks found.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</x-app-layout>
