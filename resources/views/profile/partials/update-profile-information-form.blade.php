{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}
{{-- Only Name & Email – Super Clean & Simple --}}

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Edit Login Details
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Update the name and email you use to log in.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div>
            <x-input-label for="name" value="Name" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full"
                value="{{ old('name', auth()->user()->name) }}"
                required
                autofocus
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Field -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full"
                value="{{ old('email', auth()->user()->email) }}"
                required
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>
                Save Changes
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-600 font-medium">
                    Saved successfully!
                </p>
            @endif
        </div>
    </form>
</section>