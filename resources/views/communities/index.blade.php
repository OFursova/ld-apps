<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Communities') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-jet-banner :message="session('message')"></x-jet-banner>

            <h3 class="mt-4 text-2xl text-indigo-500">My Communities</h3>

            <x-jet-button class="mt-4 mb-4">
                <a href="{{ route('communities.create') }}">{{ __("Add new community") }}</a>
            </x-jet-button>

            <table class="w-full whitespace-no-wrap w-full whitespace-no-wrap bg-gray-50">
                <thead>
                <tr class="font-bold bg-gray-100">
                    <th class="border px-6 py-4">Name</th>
                    <th class="border px-6 py-4">Description</th>
                    <th class="border px-1 py-4"></th>
                </tr>
                </thead>
                @forelse ($communities as $community)
                    <tr>
                        <td class="border px-6 py-4"><a href="{{ route('communities.show', $community) }}"></a>{{ $community->name }}</td>
                        <td class="border px-6 py-4">{{ $community->description }}</td>
                        <td class="border px-1 py-4 text-center">
                            <x-jet-button><a href="{{ route('communities.edit', $community) }}">Edit</a>
                            </x-jet-button>
                            <form action="{{ route('communities.destroy', $community->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                @csrf
                                <x-buy-button class="mt-4 mb-4 self-center bg-red-600">Delete</x-buy-button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No communities yet.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</x-app-layout>
