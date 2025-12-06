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

        {{-- Page Content --}}
        <main class="flex-1 pt-[110px] sm:pt-16 pb-[60px] sm:pb-0">
            <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-0">
                @yield('content')
            </div>
        </main>

        {{-- Desktop Footer --}}
        @include('partials.footer-desktop')

        {{-- Bottom Navigation (mobile) --}}
        @include('partials.footer')

    </div>

</body>
</html>
