<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm profile-muted">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6 profile-form">
        @csrf
        @method('put')

        <div class="profile-field">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <div class="relative">
                <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full pr-11" autocomplete="current-password" />
                <button
                    type="button"
                    data-toggle-target="#update_password_current_password"
                    class="absolute inset-y-0 right-3 z-10 flex items-center text-gray-400 hover:text-gray-600"
                    aria-label="Toggle password visibility"
                >
                    <svg data-eye="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3.2"/>
                    </svg>
                    <svg data-eye="closed" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 3l18 18"/>
                        <path d="M10.6 10.6a2.8 2.8 0 0 0 2.8 2.8"/>
                        <path d="M9.2 5.6A10.6 10.6 0 0 1 12 5c6.5 0 10 7 10 7a18.4 18.4 0 0 1-3.6 4.6"/>
                        <path d="M6.1 6.1C3.7 7.8 2 12 2 12a18.4 18.4 0 0 0 4.6 5.4A10.7 10.7 0 0 0 12 19a10.8 10.8 0 0 0 4.4-.9"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="profile-field">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <div class="relative">
                <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full pr-11" autocomplete="new-password" />
                <button
                    type="button"
                    data-toggle-target="#update_password_password"
                    class="absolute inset-y-0 right-3 z-10 flex items-center text-gray-400 hover:text-gray-600"
                    aria-label="Toggle password visibility"
                >
                    <svg data-eye="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3.2"/>
                    </svg>
                    <svg data-eye="closed" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 3l18 18"/>
                        <path d="M10.6 10.6a2.8 2.8 0 0 0 2.8 2.8"/>
                        <path d="M9.2 5.6A10.6 10.6 0 0 1 12 5c6.5 0 10 7 10 7a18.4 18.4 0 0 1-3.6 4.6"/>
                        <path d="M6.1 6.1C3.7 7.8 2 12 2 12a18.4 18.4 0 0 0 4.6 5.4A10.7 10.7 0 0 0 12 19a10.8 10.8 0 0 0 4.4-.9"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="profile-field">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <div class="relative">
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full pr-11" autocomplete="new-password" />
                <button
                    type="button"
                    data-toggle-target="#update_password_password_confirmation"
                    class="absolute inset-y-0 right-3 z-10 flex items-center text-gray-400 hover:text-gray-600"
                    aria-label="Toggle password visibility"
                >
                    <svg data-eye="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/>
                        <circle cx="12" cy="12" r="3.2"/>
                    </svg>
                    <svg data-eye="closed" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="hidden h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M3 3l18 18"/>
                        <path d="M10.6 10.6a2.8 2.8 0 0 0 2.8 2.8"/>
                        <path d="M9.2 5.6A10.6 10.6 0 0 1 12 5c6.5 0 10 7 10 7a18.4 18.4 0 0 1-3.6 4.6"/>
                        <path d="M6.1 6.1C3.7 7.8 2 12 2 12a18.4 18.4 0 0 0 4.6 5.4A10.7 10.7 0 0 0 12 19a10.8 10.8 0 0 0 4.4-.9"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 profile-actions">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
