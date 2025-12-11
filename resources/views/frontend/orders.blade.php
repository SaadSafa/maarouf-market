@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h1 class="text-xl font-bold text-gray-900 mb-4">My Orders</h1>

    @if($orders->count())
        <div class="space-y-3">
            @foreach($orders as $order)
                <a href="{{ route('orders.show', $order->id) }}"
                   class="block bg-white rounded-2xl shadow-sm p-4 border border-gray-100 hover:border-green-400">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">
                                Order #{{ $order->id }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-bold text-green-600">
                                {{ number_format($order->total, 0) }} LBP
                            </p>
                            
                            @php
                                $statusClass = match($order->status) {
                                    'pending'     => 'bg-yellow-100 text-yellow-700',
                                    'placed'      => 'bg-blue-100 text-blue-700',
                                    'picking'     => 'bg-purple-100 text-purple-700',
                                    'picked'      => 'bg-indigo-100 text-indigo-700',
                                    'indelivery'  => 'bg-orange-100 text-orange-700',
                                    'completed'   => 'bg-green-100 text-green-700',
                                    'cancelled'   => 'bg-red-100 text-red-700',
                                    default       => 'bg-gray-100 text-gray-700',
                                };
                            @endphp

                            <span class="text-xs px-2 py-1 rounded-full {{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
            <p class="text-sm text-gray-600 mb-2">You have no orders yet.</p>
            <a href="{{ route('home') }}" class="text-sm text-green-600 font-semibold">
                Start shopping
            </a>
        </div>
    @endif
</div>
@endsection
