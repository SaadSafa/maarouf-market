@props(['product'])

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 flex flex-col overflow-hidden 
            hover:shadow-lg hover:border-green-500 transition">

    {{-- Product Image --}}
    <a href="{{ route('product.show', $product->id) }}" class="relative block">
        <div class="aspect-[4/5] bg-slate-50 overflow-hidden">
            <img 
                src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x400?text=Product' }}"
                alt="{{ $product->name }}"
                class="w-full h-full object-cover transition duration-300 hover:scale-105"
            >
        </div>

        {{-- OFFER Badge --}}
        @if(!empty($product->is_on_sale))
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
            <p class="text-[11px] text-slate-500 mt-0.5">
                {{ $product->unit }}
            </p>
        @endif

        {{-- Price + Details --}}
        <div class="mt-2 flex items-center justify-between">
            <p class="text-[15px] font-extrabold text-green-600">
                {{ number_format($product->price, 0) }} L.L
            </p>

            <a href="{{ route('product.show', $product->id) }}"
               class="text-[11px] text-slate-500 hover:text-green-600 hover:underline">
                Details
            </a>
        </div>

        {{-- Add to Cart --}}
        <form action="{{ route('cart.add', $product->id) }}" method="POST"
              class="add-to-cart-form flex items-center gap-2">
            @csrf

            {{-- Quantity Selector --}}
            <div class="flex items-center rounded-full border border-slate-300 bg-white overflow-hidden">

                <button type="button"
                        onclick="let input=this.nextElementSibling; if(input.value>1) input.stepDown();"
                        class="px-3 py-1.5 text-slate-700 hover:bg-slate-100 transition text-xs font-bold">
                    −
                </button>

                <input type="number"
                       name="quantity"
                       min="1"
                       value="1"
                       class="w-10 text-center text-sm font-semibold border-x border-slate-200 focus:outline-none
                              [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" />

                <button type="button"
                        onclick="this.previousElementSibling.stepUp();"
                        class="px-3 py-1.5 text-slate-700 hover:bg-slate-100 transition text-xs font-bold">
                    +
                </button>

            </div>

            {{-- Add Button --}}
            <button type="submit"
                    class="flex-1 text-xs font-semibold bg-green-600 hover:bg-green-700 text-white 
                           rounded-full py-2 shadow-md hover:shadow-lg transition">
                Add
            </button>
        </form>

    </div>
</div>
