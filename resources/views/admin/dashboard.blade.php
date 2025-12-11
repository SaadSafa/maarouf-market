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

<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900">Dashboard</h1>
        <p class="text-slate-500">Welcome back, here’s what’s happening today.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($stats as $stat)
            <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-slate-100 p-4 flex flex-col gap-2">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-slate-500 mb-1">{{ $stat['title'] }}</p>
                        <h3 class="text-2xl font-bold text-slate-900">{{ $stat['value'] }}</h3>
                    </div>
                    <div class="p-2 rounded-lg {{ $stat['bg'] }} {{ $stat['color'] }}">
                        <span class="text-xs font-semibold">{{ $stat['trend'] === 'up' ? '↑' : '↓' }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-1 text-xs font-medium
                    {{ $stat['trend'] === 'up' ? 'text-emerald-600' : 'text-orange-600' }}">
                    <span>{{ $stat['change'] }}</span>
                    <span class="text-slate-400">vs last month</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Revenue Overview</h2>
                    <p class="text-xs text-slate-500">Last 7 days</p>
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                    +8.5% growth
                </span>
            </div>
            <div class="h-64 flex items-center justify-center text-slate-400 text-sm">
                Chart placeholder (integrate Chart.js or similar here)
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Low Stock</h2>
                    <p class="text-xs text-slate-500">Products below threshold</p>
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-medium text-orange-600 bg-orange-50 px-2 py-1 rounded-full">
                    {{ count($lowStock) }} items
                </span>
            </div>
            <div class="space-y-3">
                @foreach($lowStock as $product)
                    <div class="flex items-center justify-between px-2 py-2 rounded-lg hover:bg-slate-50">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-slate-900">{{ $product['name'] }}</span>
                            <span class="text-xs text-slate-500">{{ $product['name'] }}</span>
                        </div>
                        <span class="inline-flex items-center gap-1 text-xs font-medium text-orange-700 bg-orange-50 px-2 py-1 rounded-full">
                            {{ $product['stock'] }} in stock
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Recent Orders</h2>
                <p class="text-xs text-slate-500">Latest activity</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-left text-xs text-slate-500">
                        <th class="py-2 pr-4">Order</th>
                        <th class="py-2 pr-4">Customer</th>
                        <th class="py-2 pr-4">Total</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2 pr-4">When</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr class="border-b border-slate-50">
                            <td class="py-2 pr-4 font-medium text-slate-900">{{ $order['id'] }}</td>
                            <td class="py-2 pr-4 text-slate-700">{{ $order['customer'] }}</td>
                            <td class="py-2 pr-4 text-slate-900">{{ $order['total'] }}</td>
                            <td class="py-2 pr-4">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs
                                    @if($order['status'] === 'Completed') bg-emerald-50 text-emerald-700
                                    @elseif($order['status'] === 'In Delivery') bg-blue-50 text-blue-700
                                    @elseif($order['status'] === 'Pending') bg-amber-50 text-amber-700
                                    @else bg-slate-50 text-slate-700
                                    @endif">
                                    {{ $order['status'] }}
                                </span>
                            </td>
                            <td class="py-2 pr-4 text-slate-500">{{ $order['created_at'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-400">No recent orders.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
