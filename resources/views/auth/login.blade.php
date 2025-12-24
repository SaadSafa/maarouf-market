<x-guest-layout>
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-emerald-900 to-green-800 px-4">

    <div class="w-full max-w-6xl min-h-[560px] bg-white rounded-2xl shadow-2xl overflow-hidden
        grid grid-cols-1 lg:grid-cols-2">

        <!-- LEFT PANEL -->
        <div class="hidden lg:flex flex-col justify-center
            bg-gradient-to-br from-green-700 to-emerald-800
            text-white px-16">

            <h1 class="text-4xl font-bold tracking-wide mb-4">
                Maarouf Market
            </h1>

            <p class="text-lg opacity-90 mb-12 max-w-md">
                Sign in to shop your daily essentials easily and securely.
            </p>

            <ul class="space-y-4 text-base opacity-95">
                <li>✓ Browse fresh products & groceries</li>
                <li>✓ Add items to your cart and checkout</li>
                <li>✓ Track your orders and purchases</li>
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
                        Shop your daily essentials
                    </p>
                </div>

                <h2 class="text-2xl font-semibold text-gray-800 mb-2">
                    Customer Login
                </h2>

                <p class="text-sm text-gray-500 mb-6">
                    Login to your account to start shopping
                </p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

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
                            autofocus
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
                            autocomplete="current-password"
                            placeholder="••••••••"
                        />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- OPTIONS -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300 text-green-600 focus:ring-green-600"
                            >
                            <span class="ms-2 text-gray-600">
                                Remember me
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-green-600 hover:underline">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- LOGIN BUTTON -->
                    <button
                        type="submit"
                        class="w-full bg-green-600 hover:bg-green-700
                        text-white font-semibold py-3 rounded-lg
                        transition shadow-md tracking-wide">
                        Login & Start Shopping
                    </button>
                </form>

                <!-- REGISTER -->
                @if (Route::has('register'))
                    <div class="mt-6 text-sm text-center text-gray-600">
                        New customer?
                        <a href="{{ route('register') }}"
                           class="text-green-600 font-medium hover:underline">
                            Create an account
                        </a>
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>
</x-guest-layout>