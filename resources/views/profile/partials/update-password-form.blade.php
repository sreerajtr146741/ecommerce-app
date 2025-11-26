{{-- resources/views/profile/partials/update-password-form.blade.php --}}
{{-- Fully working password update – no route errors --}}

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a strong password for security.') }}
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update-password') }}" class="mt-6 space-y-6">
        @csrf

        <!-- Current Password -->
        <div>
            <x-input-label for="current_password" value="{{ __('Current Password') }}" />
            <x-text-input
                id="current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="password" value="{{ __('New Password') }}" />
            <x-text-input
                id="password"
                name="password"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
            <x-text-input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                autocomplete="new-password"
            />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <x-primary-button>
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-600 font-medium">
                    {{ __('Password updated successfully!') }}
                </p>
            @endif
        </div>
    </form>
</section>