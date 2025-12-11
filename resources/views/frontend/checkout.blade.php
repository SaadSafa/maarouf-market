@extends('layouts.app')



@section('content')

<div class="max-w-5xl mx-auto px-4">

    <h1 class="text-xl font-bold text-gray-900 mb-4">Checkout</h1>



    @if(!$cart || $cart->items->count() === 0)

        <div class="bg-white rounded-2xl shadow-sm p-6 text-center">

            <p class="text-sm text-gray-600 mb-2">Your cart is empty.</p>

            <a href="{{ route('home') }}" class="text-sm text-green-600 font-semibold">

                Go back to shopping

            </a>

        </div>

    @else
        
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 border border-red-200 p-3 rounded-lg mb-4 text-sm">
                <strong>Please fix the following errors:</strong>
                <ul class="list-disc ml-4 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="grid md:grid-cols-3 gap-4">

            {{-- Left: customer info --}}

            <div class="md:col-span-2 bg-white rounded-2xl shadow-sm p-4">

                <form action="{{ route('checkout.confirm') }}" method="POST">

                    @csrf



                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="customer_name"
                            value="{{ old('customer_name', auth()->user()->name) }}"
                            class="w-full px-3 py-2 border rounded-lg text-sm @error('full_name') border-red-500 @enderror">
                        @error('customer_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Phone</label>
                        <input type="text" name="customer_phone"
                            value="{{ old('customer_phone', auth()->user()->phone ?? '') }}"
                            class="w-full px-3 py-2 border rounded-lg text-sm @error('phone') border-red-500 @enderror">
                        @error('customer_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Address</label>
                        <input type="text" name="address"
                            value="{{ old('address', auth()->user()->address ?? '') }}"
                            class="w-full px-3 py-2 border rounded-lg text-sm @error('address') border-red-500 @enderror">
                        @error('address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                    <div class="mb-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Location / Area</label>
                        <input type="text" name="area"
                            value="{{ old('area', default: auth()->user()->location ?? '') }}"
                            class="w-full px-3 py-2 border rounded-lg text-sm @error('location') border-red-500 @enderror">
                        @error('area')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Note (optional)</label>
                        <textarea name="note" rows="3"
                                class="w-full px-3 py-2 border rounded-lg text-sm @error('note') border-red-500 @enderror">{{ old('note') }}</textarea>
                        @error('note')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>




                    <button type="submit"

                            class="w-full bg-green-600 text-white py-2 rounded-full font-semibold hover:bg-green-700">

                        Confirm Order

                    </button>

                </form>

            </div>



            {{-- Right: order summary --}}

            <div class="bg-white rounded-2xl shadow-sm p-4">

                <h2 class="text-sm font-bold text-gray-800 mb-3">Order Summary</h2>

                @php $total = 0; @endphp

                @foreach($cart->items as $item)

                    @php

                        $lineTotal = $item->quantity * $item->product->price;

                        $total += $lineTotal;

                    @endphp

                    <div class="flex justify-between text-sm mb-1">

                        <span class="text-gray-700">

                            {{ $item->product->name }} &times; {{ $item->quantity }}

                        </span>

                        <span class="font-semibold">

                            {{ number_format($lineTotal, 0) }} LBP

                        </span>

                    </div>

                @endforeach

                <hr class="my-3">

                <div class="flex justify-between text-sm font-bold">

                    <span>Total</span>

                    <span class="text-green-600 text-lg">

                        {{ number_format($total, 0) }} LBP

                    </span>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection

