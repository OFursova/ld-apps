<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My community') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-gray-50 border rounded-md">
            <div class="mx-auto bg-gray-100">
                <h3 class="text-2xl p-4">{{ $community->name }}: Add Post</h3>
            </div>
            <x-jet-validation-errors class="m-4"/>
            <div class="w-9/12 mx-auto flex flex-col items-center py-4">
                <form action="{{ route('communities.posts.store', $community) }}" method="POST"
                      class="flex flex-col justify-between items-center sm:items-start w-4/5">
                    @csrf

                    <div class="flex justify-between mb-4 w-full">
                        <x-jet-label for="title" class="text-lg mr-4">Title:</x-jet-label>
                        <x-jet-input class="self-stretch w-3/4" name="title" id="title" type="text" :value="old('title')"
                                     required></x-jet-input>
                    </div>

                    <div class="flex justify-between mb-4 w-full">
                        <x-jet-label for="post_text" class="text-lg mr-4">Post Text:</x-jet-label>
                        <x-textarea class="self-stretch w-3/4" name="post_text" id="post_text">
                            {{ old('post_text') }}
                        </x-textarea>
                    </div>

                    <div class="flex justify-between mb-4 w-full">
                        <x-jet-label for="post_url" class="text-lg mr-4">URL link:</x-jet-label>
                        <x-jet-input class="self-stretch w-3/4" name="post_url" id="post_url" type="text" :value="old('post_url')"
                                     ></x-jet-input>
                    </div>

                    <div class="flex justify-between mb-4 w-full">
                        <x-jet-label for="post_image" class="text-lg mr-4">Post Image:</x-jet-label>
                        <x-jet-input class="self-stretch w-3/4" name="post_image" id="post_image" type="file" :value="old('post_image')"
                        ></x-jet-input>
                    </div>

                    <x-buy-button class="mt-4 mb-4 self-center">Add a Post</x-buy-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

