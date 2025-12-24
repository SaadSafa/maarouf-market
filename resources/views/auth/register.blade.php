<x-guest-layout>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br  from-emerald-900 to-green-800 px-4">

    <div class="w-full max-w-6xl min-h-[560px] bg-white rounded-2xl shadow-2xl overflow-hidden
        grid grid-cols-1 lg:grid-cols-2">

        <!-- LEFT PANEL -->
        <div class="hidden lg:flex flex-col justify-center
            bg-gradient-to-br from-green-700 to-emerald-800
            text-white px-16">

            <h1 class="text-4xl font-bold tracking-wide mb-4">
                Join Maarouf Market
            </h1>

            <p class="text-lg opacity-90 mb-12 max-w-md">
                Create an account to shop fresh groceries, track your orders,
                and enjoy a smooth shopping experience.
            </p>

            <ul class="space-y-4 text-base opacity-95">
                <li>✓ Fast & secure checkout</li>
                <li>✓ Track your purchases</li>
                <li>✓ Personalized shopping experience</li>
            </ul>
        </div>

        <!-- RIGHT PANEL -->
        <div class="flex items-center justify-center px-6 sm:px-10 lg:px-16">
            <div class="w-full max-w-sm">

                <!-- MOBILE HEADER -->
                <div class="lg:hidden text-center mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">
                        Maarouf Market
                    </h1>
                    <p class="text-sm text-gray-500">
                        Create your account
                    </p>
                </div>

                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    Customer Registration
                </h2>

                <p class="text-sm text-gray-500 mb-6">
                    Fill in your details to start shopping
                </p>

                <form method="POST" action="{{ route('register') }}" class="space-y-5">
                    @csrf

                    <!-- NAME -->
                    <div>
                        <x-input-label for="name" value="Full Name" />
                        <x-text-input
                            id="name"
                            class="block mt-1 w-full rounded-lg border-gray-300 bg-gray-50
                            focus:bg-white focus:border-green-600 focus:ring-green-600 transition"
                            type="text"
                            name="name"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Your full name"
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <x-input-label for="email" value="Email Address" />
                        <x-text-input
                            id="email"
                            class="block mt-1 w-full rounded-lg border-gray-300 bg-gray-50
                            focus:bg-white focus:border-green-600 focus:ring-green-600 transition"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                            placeholder="you@example.com"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

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
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div>
                        <x-input-label for="password_confirmation" value="Confirm Password" />
                        <x-text-input
                            id="password_confirmation"
                            class="block mt-1 w-full rounded-lg border-gray-300 bg-gray-50
                            focus:bg-white focus:border-green-600 focus:ring-green-600 transition"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- REGISTER BUTTON -->
                    <button
                        type="submit"
                        class="w-full bg-green-600 hover:bg-green-700
                        text-white font-semibold py-3 rounded-lg
                        transition shadow-md tracking-wide">
                        Create Account
                    </button>
                </form>

                <!-- LOGIN LINK -->
                <div class="mt-6 text-sm text-center text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}"
                       class="text-green-600 font-medium hover:underline">
                        Login here
                    </a>
                </div>

            </div>
        </div>

    </div>

</div>

</x-guest-layout>
