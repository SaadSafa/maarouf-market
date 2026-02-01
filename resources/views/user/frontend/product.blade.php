@extends('layouts.app')

@section('title', $product->name)

@section('content')

    <section class="mt-3 mb-6">

        {{-- ========================== --}}
        {{-- Product Image --}}
        {{-- ========================== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-50 overflow-hidden">

            {{-- sold out badge --}}
            @if(!$product->is_active)
                <span class="absolute top-2 left-2 bg-red-600 text-white text-xs font-bold py-1 px-3 rounded z-10">
                    SOLD OUT
                </span>
            @endif

            <div class="overflow-hidden">
                <center>
                <img height="50px"
                    src="{{ $product->image ? asset('storage/'.$product->image) : 'https://via.placeholder.com/600x600?text=Product' }}"
                    alt="{{ $product->name }}"
                >
                </center>
            </div>
        </div>


        {{-- ========================== --}}
        {{-- Product Information --}}
        {{-- ========================== --}}
        <div class="mt-5 space-y-3">

            {{-- Title --}}
            <h1 class="text-xl font-bold text-slate-900">
                {{ $product->name }}
            </h1>

            {{-- Unit --}}
            @if(!empty($product->unit))
                <p class="text-sm text-slate-500">
                    Unit: {{ $product->unit }}
                </p>
            @endif

            {{-- Description --}}
            @if(!empty($product->description))
                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ $product->description }}
                </p>
            @endif

            {{-- Category --}}
            @if($product->category)
                <p class="text-sm text-slate-500">
                    Category:
                    <a href="{{ url('/?category=' . $product->category->id) }}"
                       class="text-green-700 font-medium">
                        {{ $product->category->name }}
                    </a>
                </p>
            @endif


            {{-- Price --}}
            <p class="text-2xl font-bold text-green-600">
                {{ number_format($product->price, 0) }} L.L
            </p>

        </div>


        {{-- ========================== --}}
        {{-- Add to Cart --}}
        {{-- ========================== --}}
        @if(!$product->is_active)
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-200 p-4">
                <button disabled
                    class="w-full bg-gray-400 text-white font-semibold text-sm py-2 rounded-full">
                    Sold Out
                </button>
            </div>
        @else
            <div class="mt-6 bg-white rounded-2xl shadow-sm border border-slate-100 p-4">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form flex  items-center gap-3">
                    @csrf

                    {{-- Quantity Selector --}}
                    <div class="flex items-center rounded-full border border-slate-300 overflow-hidden text-sm bg-white">
                        <button type="button"
                onclick="let input=this.parentNode.querySelector('input'); if(input.value>1) input.stepDown()"
                class="px-3 py-2 text-slate-700 hover:bg-slate-100 transition text-sm font-bold">
                    -
                </button>

                <input
                    type="number"
                    name="quantity"
                    min="1"
                    value="1"
                    class="w-12 text-center text-sm font-semibold border-x border-slate-200 bg-white
                        focus:outline-none [appearance:textfield]
                        [&::-webkit-inner-spin-button]:appearance-none
                        [&::-webkit-outer-spin-button]:appearance-none" />

                <button type="button"
                        onclick="this.parentNode.querySelector('input').stepUp()"
                        class="px-3 py-2 text-slate-700 hover:bg-slate-100 transition text-sm font-bold">
                    +
                </button>

            </div>

                    {{-- Add to cart button --}}
                    <button type="submit"
                            class="flex-1 inline-flex items-center justify-center gap-2 bg-green-600 hover:bg-green-700
                                text-white font-semibold text-sm py-2 rounded-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 4.5h2.386a1.5 1.5 0 0 1 1.447 1.123l.347 1.387m0 0 1.248 4.992A1.5 1.5 0 0 0 9.147 13.5h8.978a1.5 1.5 0 0 0 1.458-1.126l1.191-4.754a.75.75 0 0 0-.728-.945H6.43" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm9 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg> Add to cart
                    </button>
                </form>
            </div>
        @endif    
    </section>

@endsection
