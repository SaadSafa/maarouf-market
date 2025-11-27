@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4">
    <div class="grid md:grid-cols-2 gap-6">
        {{-- Image --}}
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="h-64 md:h-80 bg-gray-100">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        No image available
                    </div>
                @endif
            </div>
        </div>

        {{-- Info --}}
        <div class="bg-white rounded-2xl shadow-sm p-5 flex flex-col">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                {{ $product->name }}
            </h1>
            <p class="text-sm text-gray-600 mb-3">
                {{ $product->description }}
            </p>

            <p class="text-2xl font-extrabold text-green-600 mb-4">
                {{ number_format($product->price, 0) }} LBP
            </p>

            @auth
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                    @csrf
                    <div class="flex items-center gap-3 mb-3">
                        <label class="text-sm text-gray-700">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1"
                               class="w-20 px-2 py-1 border rounded-lg text-sm">
                    </div>
                    <button type="submit"
                            class="w-full bg-green-600 text-white py-2 rounded-full font-semibold hover:bg-green-700">
                        Add to Cart
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-500 mt-4">
                    <a href="{{ route('login') }}" class="text-green-600 underline">Login</a> to add items to your cart.
                </p>
            @endauth
        </div>
    </div>

    {{-- Related products --}}
    @if($related->count())
        <div class="mt-8">
            <h2 class="text-lg font-bold text-gray-800 mb-3">Related Products</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($related as $item)
                    <a href="{{ route('product.show', $item->id) }}"
                       class="bg-white rounded-xl shadow-sm overflow-hidden block">
                        <div class="h-28 bg-gray-100">
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}"
                                     alt="{{ $item->name }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-2">
                            <p class="text-xs font-semibold text-gray-900 line-clamp-2">
                                {{ $item->name }}
                            </p>
                            <p class="text-xs text-green-600 font-bold mt-1">
                                {{ number_format($item->price, 0) }} LBP
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
