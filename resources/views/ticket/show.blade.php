<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <h1 class="text-lg font-bold">{{ $ticket->title }}</h1>
        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class=" flex justify-between pt-2">
                <p>{{ $ticket->description }}</p>
                <p>{{ $ticket->created_at->diffForHumans() }}</p>
                
            </div>
            <div class="flex flex-col items-center">
                @if ($ticket->attachment)
                    <a 
                        href="{{ '/storage/' . $ticket->attachment }}"
                        target="_blank"
                        class="">
                    <img src="{{'/storage/'.$ticket->attachment}}" width="200" height="200" class="rounded-lg">
                    </a>
                @endif
            </div>

            <div class="flex justify-between mt-2">
                <div class="flex">
                    <a href="{{ route('ticket.edit', $ticket->id) }}>
                        <x-primary-button>Edit</x-primary-button>
                    </a>

                    <form class="ml-2" action="{{ route('ticket.destroy', $ticket->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <x-primary-button>Delete</x-primary-button>
                    </form>
                </div>
                {{-- the following section will only be running if the user is admin --}}
                @if (auth()->user()->isAdmin)
                    <div class="flex">
                        <form action="{{ route('ticket.update', $ticket->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="status" value="resolved" />
                            <x-primary-button>Resolve</x-primary-button>
                        </form>
                        <form action="{{ route('ticket.update', $ticket->id) }}" method="post">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="status" value="rejected" />
                            <x-primary-button class="ml-2">Reject</x-primary-button>
                        </form>
                    </div>
                @else
                    <p>Status: {{ $ticket->status }} </p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>