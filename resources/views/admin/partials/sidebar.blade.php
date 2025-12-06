@php
    $menu = [
        [
            'title' => 'Overview',
            'items' => [
                ['icon' => 'home', 'route' => 'admin.dashboard', 'label' => 'Dashboard', 'badge' => ""],
            ]
        ],

        [
            'title' => 'Catalog',
            'items' => [
                ['icon' => 'cube', 'route' => 'admin.products.index', 'label' => 'Products', 'badge' => ""],
                ['icon' => 'tag',  'route' => 'admin.categories.index', 'label' => 'Categories', 'badge' => ""],
            ]
        ],

        [
            'title' => 'Sales',
            'items' => [
                ['icon' => 'cart', 'route' => 'admin.orders.index', 'label' => 'Orders', 'badge' => \App\Models\Order::whereNotIn('status', ['completed', 'canceled'])->count()],
            ]
        ],

        [
            'title' => 'Marketing',
            'items' => [
                ['icon' => 'megaphone', 'route' => 'admin.sliders.index', 'label' => 'Sliders', 'badge' => ""],
            ]
        ],
    ];

    function active($r) { return request()->routeIs($r); }

    function i($name, $active = false) {
        $c = $active ? 'text-emerald-400' : 'text-slate-400 group-hover:text-emerald-500';

        return match($name) {
            'home' => "<svg class='w-5 h-5 $c transition'><path stroke='currentColor' stroke-width='1.8' d='M3 10L12 3l9 7v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V10Z'/></svg>",
            'cube' => "<svg class='w-5 h-5 $c transition'><path stroke='currentColor' stroke-width='1.8' d='M12 2 4 6v8l8 4 8-4V6l-8-4Z'/></svg>",
            'tag' => "<svg class='w-5 h-5 $c transition'><path stroke='currentColor' stroke-width='1.8' d='M20 12 12 20l-8-8V4h8l8 8Z'/></svg>",
            'cart' => "<svg class='w-5 h-5 $c transition'><path stroke='currentColor' stroke-width='1.8' d='M3 3h2l3 12h10l3-8H7'/></svg>",
            'megaphone' => "<svg class='w-5 h-5 $c transition'><path stroke='currentColor' stroke-width='1.8' d='M3 11v2a3 3 0 0 0 3 3h1l4 5V3L7 8H6a3 3 0 0 0-3 3Z'/></svg>",
            default => '',
        };
    }
@endphp

{{-- MOBILE OVERLAY --}}
<div id="admin-sidebar-overlay"
     class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

{{-- SIDEBAR PREMIUM V2 --}}
<aside id="admin-sidebar"
    class="fixed lg:sticky top-0 left-0 z-50 h-screen w-72 bg-white border-r border-slate-200 shadow-2xl
           flex flex-col transition-all duration-300 ease-in-out overflow-hidden">

    {{-- HEADER --}}
    <div class="h-20 px-6 bg-gradient-to-r from-emerald-600 to-emerald-500 text-black flex items-center justify-between shadow-lg">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 flex items-center justify-center bg-white text-emerald-600 font-bold rounded-xl shadow-md">
                MM
            </div>
            <div class="leading-tight">
                <div class="text-lg font-semibold">Admin Panel</div>
                <div class="text-xs opacity-80">Management System</div>
            </div>
        </div>

        <button id="sidebar-toggle"
                class="p-2 rounded-md hover:bg-white/20 transition hidden lg:block">
            <svg id="sidebar-toggle-icon" class="w-5 h-5" fill="none" stroke="white" stroke-width="2">
                <path d="M4 6h16M4 12h16M4 18h10"/>
            </svg>
        </button>

        <button id="admin-sidebar-close"
                class="lg:hidden p-2 rounded-md hover:bg-white/10 transition">✕</button>
    </div>

    {{-- MENU --}}
    <div class="flex-1 overflow-y-auto p-4 space-y-8">

        @foreach($menu as $section)
            <div>
                <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3 sidebar-section-title">
                    {{ $section['title'] }}
                </p>

                <div class="space-y-1">
                    @foreach($section['items'] as $item)
                        @php $a = active($item['route']); @endphp

                        <div class="relative group">

                            {{-- Active highlight bar --}}
                            @if($a)
                                <div class="absolute left-0 top-0 h-full w-1 bg-emerald-600 rounded-r-lg shadow-md animate-[slideIn_.3s]"></div>
                            @endif

                            <a href="{{ route($item['route']) }}"
                               class="flex items-center gap-3 px-4 py-2.5 rounded-lg transition-all duration-200
                                      {{ $a ? 'bg-emerald-50 text-emerald-700' : 'hover:bg-slate-100 text-slate-700' }} sidebar-item">

                                {!! i($item['icon'], $a) !!}

                                <span class="font-medium sidebar-label">{{ $item['label'] }}</span>

                                {{-- Badge --}}
@if($item['badge'] !== "")
    @php $count = (int) $item['badge']; @endphp
    <span
        id="orders-badge"
        class="ml-auto text-xs px-2 py-0.5 rounded-full shadow
               bg-emerald-600 text-white
               {{ $count === 0 ? 'hidden' : '' }}">
        {{ $count === 0 ? '' : $count }}
    </span>
@endif
                            </a>

                            {{-- Tooltip when collapsed --}}
                            <span class="tooltip hidden absolute left-20 top-1/2 -translate-y-1/2 bg-slate-800 text-white px-2 py-1 rounded-md text-xs opacity-0 group-hover:opacity-100 transition">
                                {{ $item['label'] }}
                            </span>

                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

    </div>

    {{-- FOOTER --}}
    <div class="border-t border-slate-200 p-4 bg-slate-50">
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name=Admin" class="w-10 h-10 rounded-full shadow">
            <div class="leading-tight sidebar-profile">
                <p class="font-semibold text-slate-800 text-sm">Admin User</p>
                <p class="text-xs text-slate-500">admin@example.com</p>
            </div>
        </div>

        <button class="mt-3 w-full bg-emerald-600 text-white py-2 rounded-lg shadow hover:bg-emerald-700 transition">
            Logout
        </button>
    </div>

</aside>

<style>
    @keyframes slideIn {
        from { transform: translateX(-4px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
</style>
