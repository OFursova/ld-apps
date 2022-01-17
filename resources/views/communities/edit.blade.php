<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My community') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto bg-gray-50 border rounded-md">
            <div class="mx-auto bg-gray-100">
                <h3 class="text-2xl p-4">Edit A Community</h3>
            </div>
            <x-jet-validation-errors class="m-4"/>
            <div class="w-9/12 mx-auto flex flex-col items-center py-4">
                <form action="{{ route('communities.update', $community) }}" method="POST"
                      class="flex flex-col justify-between items-center sm:items-start w-4/5">
                    @csrf
                    @method('PUT')

                    <div class="flex justify-between mb-4 w-full">
                        <x-jet-label for="name" class="text-lg mr-4">Name:</x-jet-label>
                        <x-jet-input class="self-stretch w-3/4" name="name" id="name" type="text"
                                     :value="$community->name"
                                     required></x-jet-input>
                    </div>

                    <div class="flex justify-between mb-4 w-full">
                        <x-jet-label for="description" class="text-lg mr-4">Description:</x-jet-label>
                        <x-textarea class="self-stretch w-3/4" name="description" id="description">
                            {{$community->description}}
                        </x-textarea>
                    </div>

                    <div class="flex justify-between mb-4 w-full">
                        <x-jet-label for="topics[]" class="text-lg mr-4">Topics:</x-jet-label>
                        <div class="flex flex-col justify-between self-stretch w-3/4">
                            @foreach($topics as $topic)
                                <div>
                                    <x-jet-checkbox name="topics[]" id="topics[]" :value="$topic->id" :checked="$community->topics->contains($topic->id)"></x-jet-checkbox>{{$topic->name}}
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <x-buy-button class="mt-4 mb-4 self-center">Save</x-buy-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

