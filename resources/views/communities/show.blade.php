<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My community') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-gray-50 border rounded-md">
            <div class="mx-auto bg-gray-100">
                <h3 class="text-2xl p-4">{{ $community->name }}</h3>
            </div>
            <x-jet-validation-errors class="m-4"/>
            <div class="w-9/12 mx-auto flex flex-col items-center py-4">
                <form action="{{ route('communities.posts.create', $community) }}" method="GET"
                      class="flex flex-col justify-between items-center sm:items-start w-4/5">
                    @csrf

                    {{--                    <div class="flex justify-between mb-4 w-full">--}}
                    {{--                        <x-jet-label for="name" class="text-lg mr-4">Name:</x-jet-label>--}}
                    {{--                        <x-jet-input class="self-stretch w-3/4" name="name" id="name" type="text" :value="old('name')"--}}
                    {{--                                     required></x-jet-input>--}}
                    {{--                    </div>--}}

                    {{--                    <div class="flex justify-between mb-4 w-full">--}}
                    {{--                        <x-jet-label for="description" class="text-lg mr-4">Description:</x-jet-label>--}}
                    {{--                        <x-textarea class="self-stretch w-3/4" name="description" id="description" required>--}}
                    {{--                            {{ old('description') }}--}}
                    {{--                        </x-textarea>--}}
                    {{--                    </div>--}}
                    @forelse($posts as $post)
                        <a href="{{ route('communities.posts.show', [$community, $post]) }}"><h2><b>{{ $post->title }}</b></h2></a>
                        <p>{{ \Illuminate\Support\Str::words($post->post_text, 10) }}...</p>
                        <hr class="border-1 bg-gray-800 w-full my-2">
                    @empty
                        No posts found.
                    @endforelse

                    {{ $posts->links() }}
                    <x-buy-button class="mt-4 mb-4 self-center">Add a Post</x-buy-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

