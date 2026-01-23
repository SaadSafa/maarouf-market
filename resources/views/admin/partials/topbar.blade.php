<header class="fixed top-0 left-0 right-0 z-50 bg-emerald-600 shadow-sm">
    <div class="h-14 sm:h-16 flex items-center justify-between px-3 sm:px-4 lg:px-8">

        {{-- LEFT: SIDEBAR TOGGLE + TITLE --}}
        <div class="flex items-center gap-2 sm:gap-3 min-w-0 flex-1">

            {{-- SIDEBAR TOGGLE (MOBILE ONLY) --}}
            <button
                onclick="toggleSidebar()"
                class="lg:hidden w-8 h-8 sm:w-9 sm:h-9 flex items-center justify-center
                       rounded-lg bg-white/20 text-white flex-shrink-0
                       hover:bg-white/30 transition"
                aria-label="Open sidebar"
            >
                ☰
            </button>

            <div class="min-w-0 flex-1">
                <p class="text-[10px] sm:text-xs text-emerald-100 truncate">
                    Maarouf Market Admin
                </p>
                <h1 class="text-sm sm:text-base lg:text-lg font-semibold text-white truncate">
                    @yield('page-title','Dashboard')
                </h1>
            </div>
        </div>

        {{-- RIGHT: USER --}}
        @auth
            <div class="flex items-center gap-2 sm:gap-3 text-white flex-shrink-0 ml-2">
                <span class="hidden md:block text-sm truncate max-w-[120px] lg:max-w-none">{{ auth()->user()->name }}</span>
                <div class="w-8 h-8 sm:w-9 sm:h-9 bg-white/20 rounded-lg flex items-center justify-center font-semibold text-sm">
                    {{ substr(auth()->user()->name,0,1) }}
                </div>
            </div>
        @endauth

    </div>
</header>
