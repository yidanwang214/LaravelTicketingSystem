<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('User Avatar') }}
        </h2>
    </header>

    <img
        src="{{"/storage/$user->avatar"}}"
        alt="user avatar"
        width="50"
        height="50"
        class="rounded-full"
    />

    <form action="{{route('profile.avatar.ai')}}" method="POST" class="mt-4">
        @csrf 
        <p class="mt-1 text-sm text-gray-600">
            Generate avatar from AI
        </p>
        <x-primary-button>Generate Avatar</x-primary-button>
    </form>
    <p class="mt-4 text-sm text-gray-600">
        Or
    </p>

    @if (session('message'))
        <div>
            {{ session('message') }}
        </div>
    @endif

    {{-- value inside action defines where the image should be posted, /profile/avatar is a route--}}
    <form method="POST" action="{{route('profile.avatar')}}" enctype="multipart/form-data"> 
        @method('patch')
        @csrf {{-- <input type="hidden" name="_token" value="{{csrf_token()}}"> --}}
        
        
        <div>
            <x-input-label for="name" value="Upload avatar from computer"/>
            <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('name', $user->avatar)" required autofocus autocomplete="avatar"/>
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </div>



        <div class="flex items-center gap-4 mt-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
