<!DOCTYPE html>
<html lang="en" class="admin-page">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Maarouf Market Admin')</title>
    <link rel="icon" href="/favicon.ico">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/admin/history-tab.css'
    ])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <script>
        window.csrf = "{{ csrf_token() }}";
    </script>
</head>

<body class="min-h-screen bg-slate-50 font-sans">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside
        id="adminSidebar"
        class="
            fixed inset-y-0 left-0 z-50 w-72
            bg-slate-900 text-white
            transform -translate-x-full
            lg:translate-x-0
            transition-transform duration-300
        "
    >
        @include('admin.partials.sidebar')
    </aside>

    {{-- OVERLAY (mobile only) --}}
    <div
        id="sidebarOverlay"
        class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"
        onclick="toggleSidebar()"
    ></div>

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col lg:ml-72">

        {{-- TOPBAR --}}
        <header
            class="
                fixed top-0 left-0 right-0 z-30
                h-16 bg-white shadow
                flex items-center px-4
                lg:left-72
            "
        >
            {{-- MOBILE TOGGLE --}}
            <button
                onclick="toggleSidebar()"
                class="lg:hidden mr-4 text-slate-700"
            >
                ☰
            </button>

            @include('admin.partials.topbar')
        </header>

        {{-- PAGE CONTENT --}}
        <main class="pt-20 px-4 lg:px-10">
            @yield('content')
        </main>

    </div>

</div>

{{-- SIMPLE TOGGLE SCRIPT --}}
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('adminSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }
</script>
@stack('scripts')
</body>
</html>
