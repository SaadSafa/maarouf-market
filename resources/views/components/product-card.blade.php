@props(['product'])

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col overflow-hidden 
            hover:shadow-lg hover:border-green-500 transition">

    {{-- Product Image --}}
    <a href="{{ $product->is_active ? route('product.show', $product->id) : '#' }}" 
        class="relative block {{ !$product->is_active ? 'pointer-events-none' : '' }}">

        <div class="aspect-[1.2] bg-slate-100 overflow-hidden">
            <img 
                src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x400?text=Product' }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover transition duration-300 hover:scale-105"
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

        {{-- OFFER Badge --}}
        @if(!empty($product->is_on_sale) && $product->is_active)
            <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] px-2 py-0.5 
                         rounded-full shadow-md font-semibold uppercase tracking-wide">
                OFFER
            </span>
        @endif
    </a>

    {{-- Product Content --}}
    <div class="flex-1 flex flex-col px-3 pt-2 pb-3">

        {{-- Name --}}
        <h3 class="text-sm font-semibold text-slate-900 line-clamp-2 leading-snug">
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
            <p class="text-[14px] font-extrabold text-green-600">
                {{ number_format($product->price, 0) }}
                <span class="text-[10px] font-normal">L.L</span>
            </p>

            <a href="{{ route('product.show', $product->id) }}"
               class="text-[10px] text-slate-600 hover:text-green-600 hover:underline ml-1">
                Details
            </a>
        </div>

        {{-- Add to Cart --}}
        @if(!$product->is_active)

            <button disabled class="mt-2 w-full text-[11px] font-semibold bg-gray-400 text-white 
                       rounded-full py-1.5 shadow-sm cursor-not-allowed">
                       Sold Out
            </button>

        @else

            <form action="{{ route('cart.add', $product->id) }}" method="POST"
                class="add-to-cart-form flex items-center gap-2 mt-2">
                @csrf

                {{-- Quantity Selector --}}
                <div class="flex items-center rounded-full border border-slate-300 bg-white overflow-hidden">

                    <button type="button"
                            onclick="let input=this.nextElementSibling; if(input.value>1) input.stepDown();"
                            class="px-2.5 py-1 text-slate-700 hover:bg-slate-200 transition text-[11px] font-bold">
                        −
                    </button>

                    <input type="number"
                        name="quantity"
                        min="1"
                        value="1"
                        class="w-8 text-center text-[12px] font-semibold border-x border-slate-200
                                [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" />

                    <button type="button"
                            onclick="this.previousElementSibling.stepUp();"
                            class="px-2.5 py-1 text-slate-700 hover:bg-slate-100 transition text-[11px] font-bold">
                        +
                    </button>

                </div>

                {{-- Add Button --}}
                <button type="submit"
                        class="flex-1 text-[11px] font-semibold bg-green-600 hover:bg-green-700 text-white 
                            rounded-full py-1.5 shadow-md hover:shadow-lg transition">
                    Add
                </button>
            </form>
            
        @endif

    </div>
</div>
