<header class="sticky top-0 z-30 bg-emerald-600 shadow-sm">
    <div class="h-16 flex items-center justify-between px-4 lg:px-8">

        {{-- Left: mobile menu + title --}}
        <div class="flex items-center gap-3">
            <button id="admin-sidebar-open"
                    class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-xl
                           bg-emerald-500 text-white shadow-md">
                ☰
            </button>

            <div>
                <p class="text-xs text-emerald-100">Maarouf Market Admin</p>
                <h1 class="text-lg font-semibold text-white">
                    @yield('page-title','Dashboard')
                </h1>
            </div>
        </div>

        {{-- Right: search + user --}}
        <div class="flex items-center gap-4">
            <div class="hidden md:flex items-center bg-emerald-500/40 rounded-xl px-3 py-1.5">
                <span class="text-xs text-emerald-100">Search…</span>
            </div>

            @auth
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex flex-col items-end text-emerald-100">
                        <span class="text-sm font-medium">{{ auth()->user()->name }}</span>
                        <span class="text-xs">{{ auth()->user()->email }}</span>
                    </div>
                    <div class="w-9 h-9 rounded-lg bg-white/20 text-white flex items-center justify-center uppercase text-sm">
                        {{ substr(auth()->user()->name,0,1) }}
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>
