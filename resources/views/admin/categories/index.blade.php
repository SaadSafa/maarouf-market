@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="space-y-4 sm:space-y-6 px-3 sm:px-0">

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-2">
        <div>
            <h1 class="text-lg sm:text-2xl font-bold text-slate-900">Categories</h1>
            <p class="text-xs sm:text-base text-slate-500 mt-0.5 sm:mt-1">Manage product categories</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center justify-center gap-2 bg-emerald-600 text-white px-4 py-3 sm:py-2.5 rounded-lg sm:rounded-xl shadow-sm text-sm sm:text-base font-medium">
            <span class="text-xl sm:text-lg">+</span> Add Category
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">

        <!-- Category List -->
        <div class="lg:col-span-2 bg-white rounded-lg sm:rounded-2xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="border-b px-4 py-3 sm:py-3 text-xs sm:text-sm font-semibold text-slate-700 bg-slate-50 sm:bg-transparent">
                All Categories ({{ $categories->count() }})
            </div>

            <div class="divide-y">
                @foreach($categories as $category)
                    <div class="flex items-center justify-between p-4 sm:p-4 active:bg-slate-50 sm:hover:bg-slate-50">

                        <div class="flex items-center gap-3 sm:gap-3 flex-1 min-w-0">
                            @if ($category->image == null)
                            <div class="h-12 w-12 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center text-emerald-700 text-xl sm:text-xl font-bold flex-shrink-0 shadow-sm">
                                {{ strtoupper(substr($category->name,0,1)) }}
                            </div>
                            @else
                            <div class="h-12 w-12 sm:h-12 sm:w-12 rounded-lg sm:rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50 flex items-center justify-center text-emerald-700 text-xl sm:text-xl font-bold flex-shrink-0 shadow-sm">
                                <img src="{{asset('storage/' . $category->image) }}">
                            </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <div class="text-base sm:text-sm font-semibold text-slate-900 truncate mb-0.5">{{ $category->name }}</div>
                                <div class="text-xs sm:text-xs text-slate-500 font-medium">{{ $category->products_count }} products</div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 flex-shrink-0 ml-3">

                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="px-3 py-2 sm:px-0 sm:py-0 bg-emerald-50 sm:bg-transparent text-emerald-700 sm:text-emerald-600 rounded-lg sm:rounded-none text-xs font-semibold sm:font-medium text-center min-w-[60px] sm:min-w-0">
                                Edit
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Delete category?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-2 sm:px-0 sm:py-0 bg-red-50 sm:bg-transparent text-red-700 sm:text-red-600 rounded-lg sm:rounded-none text-xs font-semibold sm:font-medium w-full sm:w-auto min-w-[60px] sm:min-w-0">
                                    Delete
                                </button>
                            </form>

                        </div>

                    </div>
                @endforeach
            </div>

        </div>
        
        <!-- Overview Card -->
        <div class="bg-white rounded-lg sm:rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6 space-y-3 sm:space-y-4">
            <h2 class="text-base sm:text-lg font-semibold text-slate-900">Category Overview</h2>

            <div class="space-y-2">
                <p class="text-sm text-slate-500">
                    Total categories
                </p>
                <p class="text-3xl sm:text-2xl font-bold text-slate-900">{{ $categories->count() }}</p>
            </div>
        </div>

    </div>

</div>
@endsection
