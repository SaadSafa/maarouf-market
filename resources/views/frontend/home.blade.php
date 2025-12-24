@extends('layouts.app')

@section('title', 'Home')

@section('content')

    {{-- ============================= --}}
    {{-- Slider Section --}}
    {{-- ============================= --}}
    @if($sliders->count())
        <section class="mt-3 mb-6">
            <div class="flex gap-3 overflow-x-auto pb-1">

                @foreach($sliders as $slider)
                    <a href="{{ url('/?category=' . ($slider->category_id ?? '')) }}"
                       class="min-w-[85%] sm:min-w-[60%] lg:min-w-[40%]">
                        <div class="relative rounded-2xl overflow-hidden shadow-sm">
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
    {{-- Categories Section (Grid Type 3) --}}
    {{-- ============================= --}}
    @if($categories->count())
        <section class="mb-5">
            <h2 class="text-sm font-semibold text-slate-900 mb-2">Shop by Category</h2>

            <div class="grid grid-cols-3 sm:grid-cols-4 gap-3">

                @foreach($categories as $category)
                    <a href="#"
                       class="category-filter group flex flex-col items-center bg-white rounded-2xl border border-slate-100 p-3 shadow-sm hover:border-green-500"
                       data-category="{{ $category->id }}">

                        {{-- Category Image --}}
                        @if($category->image)
                            <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100">
                                <img src="{{ asset('storage/' . $category->image) }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition"
                                     alt="{{ $category->name }}">
                            </div>
                        @else
                            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-700 text-xs">
                                {{ strtoupper(substr($category->name, 0, 2)) }}
                            </div>
                        @endif

                        <span class="mt-1 text-[11px] font-medium text-slate-800 text-center line-clamp-2">
                            {{ $category->name }}
                        </span>
                    </a>
                @endforeach

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
