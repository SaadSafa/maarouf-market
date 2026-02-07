<x-guest-layout>

<div class="min-h-screen flex items-center justify-center  from-emerald-900 to-green-800 px-4">

    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-8 text-center">

        <h1 class="text-2xl font-bold text-gray-800 mb-3">
            Verify Your Email
        </h1>

        <p class="text-sm text-gray-600 mb-6">
            Thanks for signing up!  
            Please verify your email address by clicking the link we sent to you.
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="text-green-600 text-sm mb-4">
                A new verification link has been sent to your email.
            </p>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg">
                Resend Verification Email
            </button>
        </form>

        <button
            type="button"
            x-data
            x-on:click.prevent="$dispatch('open-modal', 'confirm-logout')"
            class="text-sm text-gray-500 hover:underline mt-4"
        >
            Log out
        </button>

    </div>

</div>

@include('user.partials.logout-modal')

</x-guest-layout>
