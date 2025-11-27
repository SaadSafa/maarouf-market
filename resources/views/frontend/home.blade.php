@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4">
    {{-- Slider --}}
    @if($sliders->count())
        <div class="mb-6">
            <div class="relative rounded-2xl overflow-hidden shadow-md">
                <div class="grid md:grid-cols-2 gap-4 bg-green-50">
                    <div class="p-6 flex flex-col justify-center">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2">
                            Fresh Groceries Delivered to Your Door
                        </h1>
                        <p class="text-gray-600 mb-4 text-sm md:text-base">
                            Order from Maarouf Market and get your daily essentials delivered quickly.
                        </p>
                        <a href="#products"
                           class="inline-block bg-green-600 text-white px-4 py-2 rounded-full text-sm font-semibold hover:bg-green-700">
                            Shop Now
                        </a>
                    </div>
                    <div class="h-48 md:h-64">
                        {{-- Just show the first slider image for now --}}
                        @php $slider = $sliders->first(); @endphp
                        <img src="{{ asset('storage/'.$slider->image) }}"
                             alt="{{ $slider->title }}"
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Search result note --}}
    @if(!empty($search))
        <p class="text-sm text-gray-600 mb-4">
            Showing results for: <span class="font-semibold">"{{ $search }}"</span>
        </p>
    @endif

    {{-- Categories --}}
    @if($categories->count())
        <div class="mb-4">
            <h2 class="text-lg font-bold text-gray-800 mb-2">Shop by Category</h2>
            <div class="flex gap-2 overflow-x-auto pb-2">
                @foreach($categories as $category)
                    <div class="min-w-[110px] bg-white border border-green-100 rounded-xl px-3 py-2 flex items-center gap-2 shadow-sm">
                        <div class="w-7 h-7 bg-green-100 rounded-full flex items-center justify-center text-xs">
                            🛒
                        </div>
                        <span class="text-xs font-semibold text-gray-800">
                            {{ $category->name }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Products --}}
    <div id="products" class="mt-4">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-lg font-bold text-gray-800">
                {{ $search ? 'Search Results' : 'Popular Products' }}
            </h2>
        </div>

        @if($products->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $product)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col border border-gray-100">
                        <div class="h-32 md:h-40 bg-gray-100">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">
                                    No image
                                </div>
                            @endif
                        </div>
                        <div class="p-3 flex flex-col flex-1">
                            <h3 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2">
                                {{ $product->name }}
                            </h3>
                            <p class="text-xs text-gray-500 mb-2 line-clamp-1">
                                {{ $product->description }}
                            </p>
                            <div class="mt-auto flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-bold text-green-600">
                                        {{ number_format($product->price, 0) }} LBP
                                    </p>
                                </div>
                                <div class="flex gap-1">
                                    <a href="{{ route('product.show', $product->id) }}"
                                       class="text-xs px-2 py-1 border border-green-500 text-green-600 rounded-full hover:bg-green-50">
                                        View
                                    </a>
                                    @auth
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="text-xs px-2 py-1 bg-green-600 text-white rounded-full hover:bg-green-700">
                                                Add
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-sm text-gray-500">No products found.</p>
        @endif
    </div>
</div>
@endsection
