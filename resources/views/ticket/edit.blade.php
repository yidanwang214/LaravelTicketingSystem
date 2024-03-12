<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class=" text-lg font-bold">Update support ticket</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{-- $ticket->id is passed as a parameter to identify the specific ticket being updated
            PATCH (Update): Used to apply partial modifications to a resource. It is typically used for updating an existing resource with specific changes. --}}
            <form method="POST" action="{{ route('ticket.update', $ticket->id) }}" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" placeholder="Event title" autofocus 
                    value="{{$ticket->title}}"/>
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-textarea
                    name="description" 
                    value="{{$ticket->description}}"/>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="mt-4">
                    @if ($ticket->attachment)
                        <a href="{{'/storage/'.$ticket->attachment }}" target="_blank">
                            <img src="{{'/storage/'.$ticket->attachment}}" height="100" width="100">
                        </a>
                    @endif
                    <x-input-label for="attachment" :value="__('Attachment (if any)')"/>
                    <x-file-input type="file" name="attachment" id="attachment"/>
                    <x-input-error :messages="$errors->get('attachment')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-3">
                        Update
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>