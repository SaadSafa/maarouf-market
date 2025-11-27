@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <h1 class="text-xl font-bold text-gray-900 mb-4">Your Cart</h1>

    @if($items->count())
        <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
            @php
                $total = 0;
            @endphp

            @foreach($items as $item)
                @php
                    $lineTotal = $item->quantity * $item->product->price;
                    $total += $lineTotal;
                @endphp
                <div class="flex items-center gap-4 py-3 border-b last:border-b-0">
                    <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden">
                        @if($item->product->image)
                            <img src="{{ asset('storage/'.$item->product->image) }}"
                                 alt="{{ $item->product->name }}"
                                 class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $item->product->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ number_format($item->product->price, 0) }} LBP each
                        </p>
                    </div>
                    <div>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                   class="w-16 px-2 py-1 border rounded-lg text-xs">
                            <button type="submit"
                                    class="text-xs text-green-600 font-semibold">
                                Update
                            </button>
                        </form>
                    </div>
                    <div class="w-24 text-right">
                        <p class="text-sm font-semibold text-gray-900">
                            {{ number_format($lineTotal, 0) }} LBP
                        </p>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="mt-1">
                            @csrf
                            <button type="submit" class="text-xs text-red-500">
                                Remove
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-4 flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Total</p>
                <p class="text-xl font-extrabold text-green-600">
                    {{ number_format($total, 0) }} LBP
                </p>
            </div>
            <a href="{{ route('checkout.index') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-full font-semibold hover:bg-green-700">
                Proceed to Checkout
            </a>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
            <p class="text-sm text-gray-600 mb-2">Your cart is empty.</p>
            <a href="{{ route('home') }}" class="text-sm text-green-600 font-semibold">
                Start shopping
            </a>
        </div>
    @endif
</div>
@endsection
