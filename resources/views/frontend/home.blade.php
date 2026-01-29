@extends('layouts.app')

@section('title', 'Home')

@section('content')

    {{-- ============================= --}}
    {{-- Slider Section --}}
    {{-- ============================= --}}
    @if($sliders->count())
        <section class="mt-3 mb-6">
            <div class="flex gap-3 overflow-x-auto pb-1 snap-x snap-mandatory scroll-smooth">

                @foreach($sliders as $slider)
                    <a href="{{ url('/?category=' . ($slider->category_id ?? '')) }}"
                       class="min-w-[85%] sm:min-w-[60%] lg:min-w-[40%] snap-start">
                        <div class="relative rounded-3xl overflow-hidden shadow-md ring-1 ring-black/5 transition hover:shadow-lg">
                            <img
                                src="{{ asset('storage/' . $slider->image) }}"
                                alt="{{ $slider->title }}"
                                class="w-full h-32 sm:h-40 lg:h-44 object-cover"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>

                            <div class="absolute bottom-2 left-3 right-3 text-white">
                                @if(!empty($slider->subtitle))
                                    <p class="text-[11px] font-medium text-white/80 uppercase tracking-wide">
                                        {{ $slider->subtitle }}
                                    </p>
                                @endif

                                @if(!empty($slider->title))
                                    <h2 class="text-lg font-bold">
                                        {{ $slider->title }}
                                    </h2>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </section>
    @endif



    {{-- ============================= --}}
    {{-- Search Results Notification --}}
    {{-- ============================= --}}
    @if(request('search'))
        <p class="text-sm text-slate-500 mb-4">
            Showing results for:  
            <span class="font-semibold text-slate-700">"{{ request('search') }}"</span>
        </p>
    @endif



    {{-- ============================= --}}
    {{-- Categories Section (Slider) --}}
    {{-- ============================= --}}
    @if($categories->count())
        <section class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-sm font-semibold text-slate-900">Shop by Category</h2>
                <div class="hidden sm:flex items-center gap-2">
                    <button type="button"
                        data-slider-prev="#category-slider"
                        class="h-7 w-7 rounded-full border border-slate-200 bg-white text-slate-600 hover:text-green-600 hover:border-green-300 shadow-sm">
                        <span class="sr-only">Previous</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 18l-6-6 6-6"/>
                        </svg>
                    </button>
                    <button type="button"
                        data-slider-next="#category-slider"
                        class="h-7 w-7 rounded-full border border-slate-200 bg-white text-slate-600 hover:text-green-600 hover:border-green-300 shadow-sm">
                        <span class="sr-only">Next</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 6l6 6-6 6"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="relative slider-fade">
                <div id="category-slider"
                    class="flex gap-3 overflow-x-auto pb-2 snap-x snap-mandatory scroll-smooth">

                @foreach($categories as $category)
                    @php
                        $isActiveCategory = (string) request('category') === (string) $category->id;
                    @endphp
                    <a href="#"
                       class="category-filter group snap-start shrink-0 w-24 sm:w-28 md:w-32 flex flex-col items-center rounded-2xl border p-3 shadow-sm transition hover:-translate-y-0.5 hover:border-green-500 {{ $isActiveCategory ? 'bg-emerald-50 border-green-500' : 'bg-white/90 border-slate-100' }}"
                       data-category="{{ $category->id }}">

                        {{-- Category Image --}}
                        @if($category->image)
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100">
                                <img src="{{ asset('storage/' . $category->image) }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition"
                                     alt="{{ $category->name }}">
                            </div>
                        @else
                            <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-100 text-green-700 text-[10px] font-semibold">
                                {{ strtoupper(substr($category->name, 0, 2)) }}
                            </div>
                        @endif

                        <span class="mt-1 text-[11px] font-medium text-slate-800 text-center line-clamp-2">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach

                </div>
            </div>
        </section>
    @endif




    {{-- ============================= --}}
    {{-- Products Listing --}}
    {{-- ============================= --}}
    <section class="mt-1 mb-6" id="products-container">

        <div class="flex items-baseline justify-between mb-2">
            <h2 class="text-sm font-semibold text-slate-900">
                @if(request('search'))
                    Search Results
                @elseif(request('category'))
                    Products in {{ optional($categories->firstWhere('id', request('category')))->name }}
                @else
                    All Products
                @endif
            </h2>

            <p class="text-[11px] text-slate-500">
                {{ $products->total() ?? $products->count() }} items
            </p>
        </div>

        {{-- ajax load --}}
        @include('partials.products-grid',['products' => $products])


    </section>

@endsection
