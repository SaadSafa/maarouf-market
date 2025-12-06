@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-2">

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="text-2xl font-extrabold text-slate-900">
            Order #{{ $order->id }}
        </h1>
        <p class="text-xs text-slate-500">
            Placed on {{ $order->created_at->format('d M Y, H:i') }}
        </p>
    </div>

    <div class="grid md:grid-cols-3 gap-4">

        {{-- ========================= --}}
        {{-- Items Section --}}
        {{-- ========================= --}}
        <div class="md:col-span-2 bg-white rounded-2xl shadow-md p-4">

            <h2 class="text-sm font-bold text-slate-800 mb-3">Order Items</h2>

            @php $total = 0; @endphp

            @foreach($order->items as $item)

                @php
                    $lineTotal = $item->quantity * $item->price_at_time;
                    $total += $lineTotal;
                @endphp

                <div class="cart-item flex items-center gap-4 py-3 border-b last:border-b-0">

                    {{-- Product Image --}}
                    <div class="w-16 h-16 rounded-xl bg-slate-100 overflow-hidden">
                        <img src="{{ $item->product->image ? asset('storage/'.$item->product->image) : 'https://via.placeholder.com/80' }}"
                             class="w-full h-full object-cover">
                    </div>

                    {{-- Product Info --}}
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-slate-900">
                            {{ $item->product->name ?? 'Product deleted' }}
                        </p>

                        <p class="text-xs text-slate-500">
                            {{ number_format($item->price_at_time, 0) }} LBP × {{ $item->quantity }}
                        </p>
                    </div>

                    {{-- Line Total --}}
                    <p class="text-sm font-bold text-slate-900">
                        {{ number_format($lineTotal, 0) }} LBP
                    </p>
                </div>

            @endforeach

        </div>

        {{-- ========================= --}}
        {{-- Summary Section --}}
        {{-- ========================= --}}
        <div class="bg-white rounded-2xl shadow-md p-4 h-fit">

            <h2 class="text-sm font-bold text-slate-800 mb-3">Order Summary</h2>

            {{-- Status --}}

            @php
                $statusColor = match($order->status) {
                    'pending'   => 'bg-yellow-500',
                    'preparing' => 'bg-blue-500',
                    'on_the_way'=> 'bg-purple-500',
                    'completed' => 'bg-green-600',
                    'cancelled' => 'bg-red-600',
                    default     => 'bg-gray-500'
                };
            @endphp

            <p class="text-xs text-slate-700 mb-2">
                <span class="font-semibold">Status:</span>
                <span id="order-status-badge" class="ml-1 inline-block px-2 py-1 rounded-full text-white text-[11px] {{ $statusColor }}">

                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}

                </span>
            </p>

            {{-- Basic Info --}}
            <p class="text-xs text-slate-600 mb-1">
                <span class="font-semibold">Name:</span> {{ $order->full_name }}
            </p>

            <p class="text-xs text-slate-600 mb-1">
                <span class="font-semibold">Address:</span> {{ $order->address }}
            </p>

            <p class="text-xs text-slate-600 mb-1">
                <span class="font-semibold">Phone:</span> {{ $order->phone }}
            </p>

            @if($order->location)
            <p class="text-xs text-slate-600 mb-1">
                <span class="font-semibold">Location:</span> {{ $order->location }}
            </p>
            @endif

            @if($order->note)
            <p class="text-xs text-slate-600 mb-3">
                <span class="font-semibold">Note:</span> {{ $order->note }}
            </p>
            @endif

            <hr class="my-3">

            {{-- Total --}}
            <div class="flex justify-between text-sm font-bold">
                <span>Total</span>
                <span class="text-green-600 text-lg">{{ number_format($total, 0) }} LBP</span>
            </div>

            @if ($order->status === 'pending')
                <button id="cancel-order-btn"
                        data-id="{{ $order->id }}"
                        onclick="openCancelModal()"
                        class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2 rounded-full shadow-sm mt-4">
                        Cancel Order
                    </button>            
            @endif

        </div>

        {{-- Cancel Order Modal --}}
        <div id="cancel-modal"
            class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-2xl p-6 w-80 shadow-xl">
                <h2 class="text-lg font-bold text-slate-900 mb-2">Cancel Order</h2>

                <p class="text-sm text-slate-600 mb-4">
                    Are you sure you want to cancel this order?<br>
                    This action cannot be undone.
                </p>

                <div class="flex justify-end gap-3">
                    <button type="button"
                            class="px-4 py-2 text-sm rounded-full bg-slate-200 hover:bg-slate-300"
                            onclick="closeCancelModal()">
                        No
                    </button>

                    <button type="button"
                            id="confirm-cancel"
                            class="px-4 py-2 text-sm rounded-full bg-red-600 text-white hover:bg-red-700">
                        Yes, Cancel
                    </button>
                </div>
            </div>
        </div>


    </div>
</div>


@endsection
