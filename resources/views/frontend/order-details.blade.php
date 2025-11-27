@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h1 class="text-xl font-bold text-gray-900 mb-2">Order #{{ $order->id }}</h1>
    <p class="text-xs text-gray-500 mb-4">
        {{ $order->created_at->format('d M Y, H:i') }}
    </p>

    <div class="grid md:grid-cols-3 gap-4">
        {{-- Items --}}
        <div class="md:col-span-2 bg-white rounded-2xl shadow-sm p-4">
            <h2 class="text-sm font-bold text-gray-800 mb-3">Items</h2>
            @php $total = 0; @endphp
            @foreach($order->items as $item)
                @php
                    $lineTotal = $item->quantity * $item->price;
                    $total += $lineTotal;
                @endphp
                <div class="flex justify-between py-2 border-b last:border-b-0 text-sm">
                    <div>
                        <p class="font-semibold text-gray-900">
                            {{ $item->product->name ?? 'Product deleted' }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ number_format($item->price, 0) }} LBP × {{ $item->quantity }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">
                            {{ number_format($lineTotal, 0) }} LBP
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Summary --}}
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h2 class="text-sm font-bold text-gray-800 mb-3">Order Info</h2>
            <p class="text-xs text-gray-600 mb-1">
                <span class="font-semibold">Status:</span>
                <span class="ml-1">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </p>
            <p class="text-xs text-gray-600 mb-1">
                <span class="font-semibold">Address:</span> {{ $order->address }}
            </p>
            <p class="text-xs text-gray-600 mb-1">
                <span class="font-semibold">Phone:</span> {{ $order->phone }}
            </p>
            @if($order->location)
                <p class="text-xs text-gray-600 mb-1">
                    <span class="font-semibold">Location:</span> {{ $order->location }}
                </p>
            @endif
            @if($order->note)
                <p class="text-xs text-gray-600 mb-3">
                    <span class="font-semibold">Note:</span> {{ $order->note }}
                </p>
            @endif

            <hr class="my-3">

            <div class="flex justify-between text-sm font-bold">
                <span>Total</span>
                <span class="text-green-600 text-lg">
                    {{ number_format($total, 0) }} LBP
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
