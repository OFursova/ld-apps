<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Listings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-jet-banner :message="session('message')"></x-jet-banner>

            <x-jet-button class="mb-4"><a href="{{ route('listings.create') }}">{{ __('Add new listing') }}</a>
            </x-jet-button>

            <div class="mb-4">
                <form action="" method="GET">
                    <x-jet-input type="text" name="title" placeholder="Title"
                                 value="{{ request('title') }}"></x-jet-input>
                    <x-select name="category">
                        <option value="">--choose category--</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                    @if(request('category') == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-select name="size">
                        <option value="">--choose size--</option>
                        @foreach($sizes as $size)
                            <option value="{{ $size->id }}"
                                    @if(request('size') == $size->id) selected @endif>
                                {{ $size->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-select name="color">
                        <option value="">--choose color--</option>
                        @foreach($colors as $color)
                            <option value="{{ $color->id }}"
                                    @if(request('color') == $color->id) selected @endif>
                                {{ $color->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-select name="city">
                        <option value="">--choose city--</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}"
                                    @if(request('city') == $city->id) selected @endif>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </x-select>
                    @livewire('listing-saved-checkbox')
                    <x-jet-button class="ml-4">Search</x-jet-button>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th></th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Category
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Size
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Color
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            City
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Price
                        </th>
                        <th class="relative px-6 py-3" colspan="2"></th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($listings as $listing)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($listing->getFirstMediaUrl('listings', 'thumb'))
                                    <img src="{{ $listing->getFirstMediaUrl('listings', 'thumb') }}"
                                         alt="{{ $listing->title }}">
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $listing->title }}
                                <br>
                                <a href="{{ route('messages.create') }}?listing_id={{$listing->id}}">✉</a>
                            </td>
                            <td class="px-6 py-4">{{ $listing->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach($listing->categories as $category)
                                    {{ $category->name }}
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach($listing->sizes as $size)
                                    {{ $size->name }}
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-row flex-wrap justify-around">
                                    @foreach($listing->colors as $color)
                                        <span
                                            style="margin: 2px; width: 20px; height: 20px; border: 1px solid #808080; background-color: {{$color->rgb}}; border-radius: 5px;"></span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->user->city->name ?? ''}}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $listing->price }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($listing->user_id != auth()->id())
                                    @livewire('listing-save-button', ['listingId' => $listing->id])
                                @endif
                                @can('update', $listing)
                                    <x-jet-button><a href="{{ route('listings.edit', $listing) }}">Edit</a>
                                    </x-jet-button>
                                @endcan
                            </td>
                            <td class="pr-4">
                                @can('delete', $listing)
                                    <form action="{{ route('listings.destroy', $listing) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-jet-danger-button type="submit" onclick="return confirm('Are you sure?')">
                                            Delete
                                        </x-jet-danger-button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="m-4 px-4 py-2">
                    {{ $listings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
