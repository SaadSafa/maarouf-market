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
                        <div class="relative">
                            <x-text-input
                                id="password"
                                class="block mt-1 w-full rounded-lg border-gray-300 bg-gray-50 pr-11
                                focus:bg-white focus:border-green-600 focus:ring-green-600 transition"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="********"
                            />
                            <button
                                type="button"
                                data-toggle-target="#password"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"
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
                        @include('user.partials.password-requirements', ['inputId' => 'password'])
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div>
                        <x-input-label for="password_confirmation" value="Confirm Password" />
                        <div class="relative">
                            <x-text-input
                                id="password_confirmation"
                                class="block mt-1 w-full rounded-lg border-gray-300 bg-gray-50 pr-11
                                focus:bg-white focus:border-green-600 focus:ring-green-600 transition"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="********"
                            />
                            <button
                                type="button"
                                data-toggle-target="#password_confirmation"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"
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
