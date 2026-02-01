@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    
    <h1 class="text-xl font-bold text-gray-900 mb-4">Your Cart</h1>

    @if($items->count())

        <div id="cart-container" class="space-y-3 mb-4">

            @php $total = 0; @endphp

            @foreach($items as $item)
                @php
                    $unitPrice = $item->price_at_time ?? $item->product->effective_price;
                    $lineTotal = $item->quantity * $unitPrice;
                    $total += $lineTotal;
                @endphp

                {{-- CART ITEM --}}
                <div
                    class="cart-item bg-white p-4 rounded-2xl shadow-sm border border-slate-100 flex flex-col sm:flex-row sm:items-center gap-4"
                    id="cart-item-{{ $item->id }}"
                    data-id="{{ $item->id }}"
                    data-price="{{ $unitPrice }}"
                >

                    {{-- IMAGE --}}
                    <div class="w-20 h-20 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                        <img src="{{ asset('storage/'.$item->product->image) }}"
                             class="w-full h-full object-cover">
                    </div>

                    {{-- INFO + QUANTITY --}}
                    <div class="flex-1">

                        {{-- Product Name --}}
                        <p class="text-sm font-semibold text-gray-900 leading-tight">
                            {{ $item->product->name }}
                        </p>

                        {{-- Price --}}
                        <p class="text-xs text-gray-500 mt-1">
                            {{ number_format($unitPrice, 0) }} LBP each
                        </p>

                        {{-- Quantity Controls --}}
                        <div class="mt-3 flex items-center gap-2">

                            <button class="qty-dec bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center text-slate-700 text-lg font-bold">
                                −
                            </button>

                            <input type="number"
                                    min="1"
                                    value="{{ $item->quantity }}"
                                    class="qty-input w-11 text-center text-sm font-semibold border-x border-slate-200 bg-white
                                            focus:outline-none [appearance:textfield]
                                            [&::-webkit-inner-spin-button]:appearance-none
                                            [&::-webkit-outer-spin-button]:appearance-none" />

                            <button class="qty-inc bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center text-slate-700 text-lg font-bold">
                                +
                            </button>

                        </div>

                    </div>

                    {{-- LINE TOTAL + REMOVE --}}
                    <div class="text-right sm:w-28">

                        <p class="text-sm font-bold text-green-600 line-total">
                            {{ number_format($lineTotal, 0) }} LBP
                        </p>

                        <button class="remove-item text-xs text-red-500 mt-1 underline">
                            Remove
                        </button>

                    </div>

                </div>
            @endforeach

        </div>

        {{-- TOTAL SECTION --}}
        <div class="bg-white rounded-2xl shadow-sm p-4 flex justify-between items-center border border-slate-100">
            <div>
                <p class="text-sm text-gray-500">Total</p>
                <p id="cart-total" class="text-2xl font-extrabold text-green-600">
                    {{ number_format($total, 0) }} LBP
                </p>
            </div>

            <a href="{{ route('checkout.index') }}"
                class="bg-green-600 text-white px-5 py-2 rounded-full font-semibold hover:bg-green-700 transition">
                Proceed to Checkout
            </a>
        </div>

    @else

        {{-- EMPTY CART --}}
        <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
            <p class="text-gray-600 mb-2 text-sm">Your cart is empty.</p>
            <a href="{{ route('home') }}" class="text-green-600 font-semibold">
                Start shopping
            </a>
        </div>

    @endif
</div>
@endsection
