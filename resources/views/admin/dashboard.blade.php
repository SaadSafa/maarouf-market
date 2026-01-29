@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $stats = $stats ?? [
        [
            'title' => "Total Products",
            'value' => $totalProducts,
            'change' => $ProductChangePercentage,
            'trend' => $ProductChangePercentage > 0 ? 'up' : 'down',
            'color' => "text-emerald-600",
            'bg' => "bg-emerald-50",
        ],
        [
            'title' => "Total Categories",
            'value' => $totalCategories,
            'change' => "",
            'trend' => "",
            'color' => "text-blue-600",
            'bg' => "bg-blue-50",
        ],
        [
            'title' => "Monthly Revenue",
            'value' => $monthRevenue,
            'change' => "+8.5%",
            'trend' => "up",
            'color' => "text-emerald-600",
            'bg' => "bg-emerald-50",
        ],
        [
            'title' => "Today's Orders",
            'value' => $todayOrders,
            'change' => "-5%",
            'trend' => "down",
            'color' => "text-orange-600",
            'bg' => "bg-orange-50",
        ],
    ];
@endphp

<div class="space-y-8">

    {{-- HEADER --}}
    <div class="flex flex-col gap-1">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-slate-900">
            Dashboard
        </h1>
        <p class="text-sm sm:text-base text-slate-500">
            Welcome back, here’s what’s happening today.
        </p>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach($stats as $stat)
            <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-medium text-slate-500">
                            {{ $stat['title'] }}
                        </p>
                        <h3 class="text-xl sm:text-2xl font-bold text-slate-900">
                            {{ $stat['value'] }}
                        </h3>
                    </div>
                    <div class="p-2 rounded-lg {{ $stat['bg'] }} {{ $stat['color'] }}">
                        {{ $stat['trend'] === 'up' ? '↑' : '↓' }}
                    </div>
                </div>

                <div class="mt-2 flex items-center gap-1 text-xs
                    {{ $stat['trend'] === 'up' ? 'text-emerald-600' : 'text-orange-600' }}">
                    <span>{{ $stat['change'] }}</span>
                    <span class="text-slate-400">vs last month</span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- MIDDLE SECTION --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- CHART --}}
<div class="xl:col-span-2 bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-2 mb-4">
        <div>
            <h2 class="text-sm font-semibold text-slate-900">
                Revenue Overview
            </h2>
            <p class="text-xs text-slate-500">Last 7 days</p>
        </div>
        <span class="text-xs text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
            +8.5% growth
        </span>
    </div>
    <div style="height: 300px;">
    <canvas id="revenueChart"></canvas>
</div>
</div>


        {{-- LOW STOCK --}}
        <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-900">
                    Low Stock
                </h2>
                <span class="text-xs text-orange-600 bg-orange-50 px-2 py-1 rounded-full">
                    {{ count($lowStock) }} items
                </span>
            </div>

            <div class="space-y-2 max-h-64 overflow-y-auto">
                @foreach($lowStock as $product)
                    <div class="flex justify-between items-center p-2 rounded-lg hover:bg-slate-50">
                        <div>
                            <p class="text-sm font-medium text-slate-900 truncate max-w-[160px]">
                                {{ $product['name'] }}
                            </p>
                            <p class="text-xs text-slate-500">
                                SKU: {{ $product['name'] }}
                            </p>
                        </div>
                        <span class="text-xs text-orange-700 bg-orange-50 px-2 py-1 rounded-full">
                            {{ $product['stock'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- RECENT ORDERS --}}
    <div class="bg-white rounded-xl border border-slate-100 p-4 shadow-sm">
        <h2 class="text-sm font-semibold text-slate-900 mb-3">
            Recent Orders
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-[640px] w-full text-sm">
                <thead class="text-xs text-slate-500 border-b">
                    <tr>
                        <th class="py-2 text-left">Order</th>
                        <th class="py-2 text-left">Customer</th>
                        <th class="py-2 text-left">Total</th>
                        <th class="py-2 text-left">Status</th>
                        <th class="py-2 text-left">When</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr class="border-b">
                            <td class="py-2 font-medium">{{ $order['id'] }}</td>
                            <td class="py-2">{{ $order['customer'] }}</td>
                            <td class="py-2">{{ $order['total'] }}</td>
                            <td class="py-2">
                                <span class="px-2 py-1 rounded-full text-xs
                                    @if($order['status'] === 'Completed') 'bg-emerald-50 text-emerald-700'
                                    @elseif($order['status'] === 'In Delivery') 'bg-blue-50 text-blue-700'
                                    @elseif($order['status'] === 'Pending') 'bg-amber-50 text-amber-700'
                                    @else bg-slate-50 text-slate-700
                                    @endif">
                                    {{ $order['status'] }}
                                </span>
                            </td>
                            <td class="py-2 text-slate-500">{{ $order['created_at'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400">
                                No recent orders.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($revenueData['labels']),
            datasets: [{
                label: 'Revenue ($)',
                data: @json($revenueData['data']),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleColor: '#f1f5f9',
                    bodyColor: '#f1f5f9',
                    borderColor: '#334155',
                    borderWidth: 1,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return '$' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b',
                        callback: function(value) {
                            return 'LBP' + (value / 1000) + 'k';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#64748b'
                    }
                }
            }
        }
    });
</script>
@endpush

@endsection
