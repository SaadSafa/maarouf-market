<x-modal name="confirm-logout" focusable>
    <form method="POST" action="{{ route('logout') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-semibold text-gray-900">
            {{ __('Log out?') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('You can log back in anytime. Are you sure you want to log out now?') }}
        </p>

        <div class="mt-6 flex justify-end gap-2">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('No, stay') }}
            </x-secondary-button>

            <x-danger-button class="ms-1">
                {{ __('Yes, log out') }}
            </x-danger-button>
        </div>
    </form>
</x-modal>
