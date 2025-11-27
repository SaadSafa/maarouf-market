<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maarouf Market</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    @php
        $cartCount = 0;
        if (auth()->check() && auth()->user()->cart) {
            $cartCount = auth()->user()->cart->items()->count();
        }
    @endphp

    {{-- Navbar --}}
    <nav class="bg-white shadow-md px-4 md:px-8 py-3 fixed top-0 w-full z-50">
        <div class="flex justify-between items-center gap-4">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="text-2xl font-extrabold text-green-600 tracking-tight">
                Maarouf <span class="text-gray-800">Market</span>
            </a>

            {{-- Search (desktop) --}}
            <form action="{{ route('home') }}" method="GET" class="hidden md:block flex-1 max-w-xl">
                <input
                    type="text"
                    name="search"
                    placeholder="Search for fresh groceries, snacks, drinks..."
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-green-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
                >
            </form>

            {{-- Right side --}}
            <div class="flex items-center gap-4">

                @auth
                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}" class="relative flex items-center">
                        <span class="text-2xl">🛒</span>
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 text-[10px] bg-red-600 text-white rounded-full px-1.5 py-0.5">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- Orders --}}
                    <a href="{{ route('orders.index') }}" class="hidden sm:inline text-sm font-medium text-gray-700 hover:text-green-600">
                        My Orders
                    </a>

                    {{-- Profile dropdown placeholder (can replace later with Breeze dropdown) --}}
                    <span class="text-sm text-gray-600">
                        Hi, {{ auth()->user()->name }}
                    </span>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-green-600 hover:text-green-700">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="hidden sm:inline-block bg-green-600 text-white text-sm px-3 py-1.5 rounded-full hover:bg-green-700">
                        Sign Up
                    </a>
                @endguest>
            </div>
        </div>

        {{-- Search (mobile) --}}
        <form action="{{ route('home') }}" method="GET" class="mt-3 md:hidden">
            <input
                type="text"
                name="search"
                placeholder="Search for products..."
                value="{{ request('search') }}"
                class="w-full px-3 py-2 border border-green-200 rounded-full focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm"
            >
        </form>
    </nav>

    {{-- Page Content --}}
    <div class="pt-24 pb-8">
        @yield('content')
    </div>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-300 py-8 mt-4">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-white mb-1">Maarouf Market</h2>
                    <p class="text-sm text-gray-400">
                        Fresh groceries, fast delivery, and trusted service in your neighborhood.
                    </p>
                </div>
                <div class="text-sm text-gray-400">
                    <p>Quick links:</p>
                    <div class="flex gap-3 mt-1 text-xs">
                        <a href="{{ route('home') }}" class="hover:text-green-400">Home</a>
                        @auth
                            <a href="{{ route('orders.index') }}" class="hover:text-green-400">My Orders</a>
                        @endauth
                        <a href="#" class="hover:text-green-400">Contact</a>
                    </div>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4">
                © {{ date('Y') }} Maarouf Market. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>
