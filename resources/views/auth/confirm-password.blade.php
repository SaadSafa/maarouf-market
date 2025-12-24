<x-guest-layout>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br  from-emerald-900 to-green-800 px-4">

    <div class="w-full max-w-4xl min-h-[420px] bg-white rounded-2xl shadow-2xl overflow-hidden
        grid grid-cols-1 lg:grid-cols-2">

        <!-- LEFT PANEL -->
        <div class="hidden lg:flex flex-col justify-center
            bg-gradient-to-br from-green-700 to-emerald-800
            text-white px-14">

            <h1 class="text-3xl font-bold mb-4">
                Security Check
            </h1>

            <p class="text-lg opacity-90 max-w-md">
                For your protection, please confirm your password before continuing.
            </p>

            <ul class="mt-10 space-y-4 text-base opacity-95">
                <li>✓ Protect your personal information</li>
                <li>✓ Secure sensitive actions</li>
                <li>✓ Keep your account safe</li>
            </ul>
        </div>

        <!-- RIGHT PANEL -->
        <div class="flex items-center justify-center px-6 sm:px-10 lg:px-14">
            <div class="w-full max-w-sm">

                <!-- MOBILE HEADER -->
                <div class="lg:hidden text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">
                        Maarouf Market
                    </h1>
                    <p class="text-sm text-gray-500">
                        Security Confirmation
                    </p>
                </div>

                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    Confirm Your Password
                </h2>

                <p class="text-sm text-gray-500 mb-6">
                    This action requires password confirmation.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf

                    <!-- PASSWORD -->
                    <div>
                        <x-input-label for="password" value="Password" />
                        <x-text-input
                            id="password"
                            class="block mt-1 w-full rounded-lg border-gray-300 bg-gray-50
                            focus:bg-white focus:border-green-600 focus:ring-green-600 transition"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- CONFIRM BUTTON -->
                    <button
                        type="submit"
                        class="w-full bg-green-600 hover:bg-green-700
                        text-white font-semibold py-3 rounded-lg
                        transition shadow-md tracking-wide">
                        Confirm & Continue
                    </button>
                </form>

                <!-- OPTIONAL BACK -->
                <div class="mt-6 text-sm text-center text-gray-600">
                    Changed your mind?
                    <a href="{{ url()->previous() }}"
                       class="text-green-600 font-medium hover:underline">
                        Go back
                    </a>
                </div>

            </div>
        </div>

    </div>

</div>

</x-guest-layout>
