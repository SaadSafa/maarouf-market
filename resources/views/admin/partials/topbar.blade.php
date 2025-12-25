<header class="fixed top-0 left-0 right-0 z-50 bg-emerald-600 shadow-sm">
    <div class="h-16 flex items-center justify-between px-4 lg:px-8">

        {{-- LEFT: SIDEBAR TOGGLE + TITLE --}}
        <div class="flex items-center gap-3">

            {{-- SIDEBAR TOGGLE (MOBILE ONLY) --}}
            <button
                onclick="toggleSidebar()"
                class="lg:hidden w-9 h-9 flex items-center justify-center
                       rounded-lg bg-white/20 text-white
                       hover:bg-white/30 transition"
                aria-label="Open sidebar"
            >
                ☰
            </button>

            <div class="min-w-0">
                <p class="text-xs text-emerald-100 truncate">
                    Maarouf Market Admin
                </p>
                <h1 class="text-base sm:text-lg font-semibold text-white truncate">
                    @yield('page-title','Dashboard')
                </h1>
            </div>
        </div>

        {{-- RIGHT: USER --}}
        @auth
            <div class="flex items-center gap-3 text-white">
                <span class="hidden sm:block">{{ auth()->user()->name }}</span>
                <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center font-semibold">
                    {{ substr(auth()->user()->name,0,1) }}
                </div>
            </div>
        @endauth

    </div>
</header>
