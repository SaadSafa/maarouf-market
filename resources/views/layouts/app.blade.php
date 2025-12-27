<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Maarouf Market - @yield('title', 'Fresh Groceries')</title>

    {{-- Breeze + Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 antialiased">

    <div class="min-h-screen flex flex-col">

        {{-- Top Navbar --}}
        @include('partials.navbar')

        {{-- Store closed banner (persistent while closed or when flash is present) --}}
        @php
            $storeOpen = function_exists('shopEnabled') ? shopEnabled() : true;
            $storeClosedFlash = session('store_closed');
        @endphp
        @if(!$storeOpen || $storeClosedFlash)
            <div class="bg-amber-100 border-b border-amber-200 text-amber-800 mt-16">
                <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-0 py-2 text-sm flex items-center gap-2">
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-200 text-amber-800 text-xs font-bold">!</span>
                    <span class="font-semibold">Ordering is currently paused.</span>
                    <span class="text-amber-900">
                        {{ $storeClosedFlash ?? 'You can browse products, but checkout is temporarily disabled.' }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 pt-[110px] sm:pt-16 pb-[60px] sm:pb-0">
            <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-0">
                {{-- Support both Blade layouts (@yield) and Blade components ({{$slot}}) --}}
                @isset($header)
                    <header class="mb-4">
                        {{ $header }}
                    </header>
                @endisset

                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </div>
        </main>

        {{-- Desktop Footer --}}
        @include('partials.footer-desktop')

        {{-- Bottom Navigation (mobile) --}}
        @include('partials.footer')

    </div>

</body>
</html>
