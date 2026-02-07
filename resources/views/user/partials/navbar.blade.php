@php
    $cartCount = auth()->check() && auth()->user()->cart
        ? auth()->user()->cart->items()->count()
        : 0;
    $storeOpen = function_exists('shopEnabled') ? shopEnabled() : true;
@endphp

<nav class="backdrop-blur fixed top-0 inset-x-0 z-50 border-b shadow-sm nav-surface">
    <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="inline-flex items-center justify-center rounded-xl bg-green-600 text-white w-8 h-8 text-lg font-bold shadow-sm">
                MM
            </span>
            <span class="font-extrabold text-lg text-slate-900 whitespace-nowrap">
                Maarouf <span class="text-green-600">Market</span>
            </span>
        </a>

        {{-- Desktop search --}}
        <form action="{{ route('home') }}" method="GET"
              class="hidden md:flex flex-1 max-w-md mx-4">
            <input autocomplete="off"
                   type="text"
                   name="search"
                   placeholder="Search for products"
                   value="{{ request('search') }}"
                   class="w-full rounded-full border border-slate-200 bg-white/80 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
        </form>

        {{-- Right side --}}
        <div class="flex items-center gap-3">

            {{-- Profile Dropdown (always visible) --}}
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="flex items-center justify-center w-9 h-9 md:w-10 md:h-10 rounded-full bg-emerald-100 text-emerald-700 font-bold ring-1 ring-emerald-200/60">
                    @auth
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-700" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 
                                     20.118a7.5 7.5 0 0 1 14.998 0A17.93 17.93 0 0 1 12 21.75c-2.8 
                                     0-5.447-.64-7.499-1.632Z" />
                        </svg>
                    @endauth
                </button>

                {{-- Dropdown menu --}}
                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-40 bg-white border border-slate-200 rounded-xl shadow-lg py-1 text-sm z-50">

                    @guest
                        <a href="{{ route('login') }}"
                           class="block px-4 py-2 hover:bg-slate-100">Login</a>

                        <a href="{{ route('register') }}"
                           class="block px-4 py-2 hover:bg-slate-100">Register</a>
                    @endguest

                    @auth
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 hover:bg-slate-100">Profile</a>

                        <a href="{{ route('orders.index') }}"
                           class="block px-4 py-2 hover:bg-slate-100">Orders</a>

                        <button
                            type="button"
                            x-data
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-logout')"
                            class="w-full text-left px-4 py-2 hover:bg-slate-100"
                        >
                            Logout
                        </button>
                    @endauth
                </div>
            </div>

            {{-- Cart --}}
            <a href="{{ route('cart.index') }}"
               class="relative flex items-center justify-center w-10 h-10 rounded-full border border-slate-200 bg-white/90 hover:bg-emerald-50">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-5 h-5 text-slate-700"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="1.5"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.25 4.5h2.386a1.5 1.5 0 0 1 1.447 1.123l.347 1.387m0 0 
                             1.248 4.992A1.5 1.5 0 0 0 9.147 13.5h8.978a1.5 1.5 0 0 0 
                             1.458-1.126l1.191-4.754a.75.75 0 0 0-.728-.945H6.43" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm9 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>

                {{-- ajax friendly to show count on cart --}}
                <span id="cart-count"
                    class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] px-1.5 rounded-full {{ $cartCount == 0 ? 'hidden' : '' }}">
                    {{ $cartCount }}
                </span>

            </a>

        </div>
    </div>

    {{-- Mobile search --}}
    <form action="{{ route('home') }}" method="GET"
          class="md:hidden px-4 pb-2">
        <input autocomplete="off"
               type="text"
               name="search"
               placeholder="Search for products"
               value="{{ request('search') }}"
               class="w-full rounded-full border border-slate-200 bg-white/90 px-4 py-2 text-sm
                      focus:outline-none focus:ring-2 focus:ring-green-500">
    </form>
</nav>

@auth
    @include('user.partials.logout-modal')
@endauth
