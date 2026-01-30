@props(['product'])

<div class="card-surface rounded-xl shadow-sm border border-slate-100 flex flex-col overflow-hidden 
            hover:shadow-md hover:border-green-500 hover:-translate-y-0.5 transition">

    {{-- Product Image --}}
    <div class="relative">
        <a href="{{ $product->is_active ? route('product.show', $product->id) : '#' }}"
            class="block {{ !$product->is_active ? 'pointer-events-none' : '' }}">

            <div class="aspect-[1/1] overflow-hidden bg-gradient-to-br from-slate-50 via-white to-slate-100 ring-1 ring-slate-200/70">
                <img
                    src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x400?text=Product' }}"
                    alt="{{ $product->name }}"
                    class="w-full h-full object-contain p-2 transition duration-300 hover:scale-105"
                >

                {{-- Sold out badge --}}
                @if(!$product->is_active)
                    <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold py-1 px-2 rounded">
                        SOLD OUT
                    </span>

                    {{-- Blur effect for sold product --}}
                    <div class="absolute inset-0 bg-white/20 backdrop-blur-[0.5px]"></div>
                @endif

            </div>
        </a>

        {{-- OFFER Badge --}}
        @if(!empty($product->is_on_sale) && $product->is_active)
            <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] px-2 py-0.5 
                         rounded-full shadow-md font-semibold uppercase tracking-wide">
                OFFER
            </span>
        @endif

        {{-- Add to Cart Popover --}}
        @if($product->is_active)
            @php
                $currentCategory = request('category');
            @endphp

            <form action="{{ route('cart.add', $product->id) }}" method="POST"
                class="add-to-cart-form cart-popover absolute right-2 bottom-2 translate-y-2 z-20">
                @csrf

                @if ($currentCategory)
                    <input type="hidden" name="category" value="{{ $currentCategory }}">
                @endif

                <div class="relative flex items-center">
                    <button type="button"
                        data-cart-toggle
                        class="h-9 w-9 rounded-full bg-green-600 text-white shadow-md hover:bg-green-700 transition flex items-center justify-center text-lg font-bold">
                        +
                    </button>

                    <div class="cart-popover-panel absolute right-10 sm:right-11 bottom-0 flex items-center gap-0.5 sm:gap-1 bg-white border border-slate-200 rounded-full shadow-lg px-1.5 sm:px-2 py-0.5">
                        <button type="button"
                                onclick="let input=this.nextElementSibling; if(input.value>1) input.stepDown();"
                                class="px-1.5 sm:px-2 py-0.5 text-slate-700 hover:bg-slate-100 rounded-full text-[11px] sm:text-[12px] font-bold">
                            -
                        </button>

                        <input type="number"
                            name="quantity"
                            min="1"
                            value="1"
                            class="w-8 sm:w-10 text-center text-[11px] sm:text-[12px] font-semibold border-x border-slate-200
                                    [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" />

                        <button type="button"
                                onclick="this.previousElementSibling.stepUp();"
                                class="px-1.5 sm:px-2 py-0.5 text-slate-700 hover:bg-slate-100 rounded-full text-[11px] sm:text-[12px] font-bold">
                            +
                        </button>

                        <button type="submit"
                                class="ml-1 h-6 w-6 sm:h-7 sm:w-7 rounded-full bg-green-600 text-white hover:bg-green-700 transition flex items-center justify-center"
                                aria-label="Add to cart">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M2 3h2l3.6 7.59a2 2 0 0 0 1.8 1.16h8.8a2 2 0 0 0 1.8-1.16L22 6H6" />
                                <circle cx="10" cy="20" r="1.5" />
                                <circle cx="18" cy="20" r="1.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    {{-- Product Content --}}
    <div class="flex-1 flex flex-col px-2.5 pt-2 pb-2.5">

        {{-- Name --}}
        <h3 class="text-[13px] font-semibold text-slate-900 line-clamp-2 leading-snug">
            {{ $product->name }}
        </h3>

        {{-- Unit --}}
        @if(!empty($product->unit))
            <p class="text-[10px] text-slate-500 mt-0.5">
                {{ $product->unit }}
            </p>
        @endif

        {{-- Price + Details --}}
        <div class="mt-1.5 flex items-center justify-between">
            @php
                $displayPrice = $product->effective_price;
                $hasDiscount = $product->discount_price !== null && $product->discount_price < $product->price;
            @endphp
            <div class="leading-tight">
                <p class="text-[13px] font-extrabold text-green-600">
                    {{ number_format($displayPrice, 0) }}
                    <span class="text-[10px] font-normal">L.L</span>
                </p>
                @if($hasDiscount)
                    <p class="text-[10px] text-slate-400 line-through">
                        {{ number_format($product->price, 0) }} L.L
                    </p>
                @endif
            </div>

            <a href="{{ route('product.show', $product->id) }}"
               class="text-[10px] text-slate-600 hover:text-green-600 hover:underline ml-1">
                Details
            </a>
        </div>
    </div>
</div>
