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
        {{-- Right: store toggle + search + user --}}
        <div class="flex items-center gap-4">
            @php $storeOpen = function_exists('shopEnabled') ? shopEnabled() : true; @endphp
            <form method="POST" action="{{ route('admin.settings.store-toggle') }}">
                @csrf
                <input type="hidden" name="value" value="{{ $storeOpen ? 0 : 1 }}">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-semibold border shadow-sm
                        {{ $storeOpen ? 'bg-white text-emerald-700 border-emerald-200' : 'bg-amber-100 text-amber-800 border-amber-200' }}">
                    <span class="w-2 h-2 rounded-full {{ $storeOpen ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                    {{ $storeOpen ? 'Store Open' : 'Store Closed' }}
                </button>
            </form>

            <!--
            <div class="hidden md:flex items-center bg-emerald-500/40 rounded-xl px-3 py-1.5">
                <span class="text-xs text-emerald-100">Search</span>
            </div>
            -->
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
</header>
