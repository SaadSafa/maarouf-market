<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Maarouf Market Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js','resources/css/admin/history-tab.css'])
    <script>
    window.csrf = "{{ csrf_token() }}";
</script>

</head>

<body class="min-h-screen bg-slate-50 font-sans flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    {{-- RIGHT SIDE CONTENT --}}
    <div class="flex-1 min-h-screen flex flex-col
                lg:pl-4      {{-- desktop sidebar offset --}}
                pl-72          {{-- mobile full width --}}
    ">

        {{-- TOPBAR --}}
        <div class="fixed top-0 right-0 
                    lg:left-72     {{-- desktop offset --}}
                    left-0         {{-- mobile full width --}}
                    h-15 z-40 bg-white shadow">
            @include('admin.partials.topbar')
        </div>

        {{-- PAGE CONTENT --}}
        <main class="
            pt-24
            p-3
            lg:p-25   {{-- larger padding on desktop --}}
        ">
            @yield('content')
        </main>

    </div>

</body>
</html>
