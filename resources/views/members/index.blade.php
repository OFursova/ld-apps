<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My team') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-jet-banner :message="session('message')"></x-jet-banner>

            <h3 class="mb-4 mt-8 text-2xl text-indigo-500">My Team</h3>

            <x-jet-button class="mt-4 mb-4">
                <a href="{{ route('members.create') }}">{{ __("Add new member") }}</a>
            </x-jet-button>

            <table class="w-full whitespace-no-wrap w-full whitespace-no-wrap bg-gray-50">
                <thead>
                <tr class="font-bold bg-gray-100">
                    <th colspan="2" class="border px-6 py-4">Team Member</th>
                    <th class="border px-1 py-4"></th>
                </tr>
                </thead>
                @forelse ($members as $member)
                    <tr>
                        <td class="border px-6 py-4">{{ $member->name }}</td>
                        <td class="border px-6 py-4">{{ $member->email }}</td>
                        <td class="border px-1 py-4 text-center">
                            <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                @csrf
                                <x-buy-button class="mt-4 mb-4 self-center bg-red-600">Delete</x-buy-button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No members in this team.</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</x-app-layout>
