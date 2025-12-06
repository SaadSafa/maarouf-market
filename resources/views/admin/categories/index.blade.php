@extends('admin.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between gap-2">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Categories</h1>
            <p class="text-slate-500 mt-1">Manage product categories</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="flex items-center gap-2 bg-emerald-600 text-white px-4 py-2.5 rounded-xl shadow-sm">
            <span class="text-lg">+</span> Add Category
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Category List -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100">

            <div class="border-b px-4 py-3 text-sm font-semibold text-slate-700">
                All Categories
            </div>

            <div class="divide-y">
                @foreach($categories as $category)
                    <div class="flex items-center justify-between p-4 hover:bg-slate-50">

                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 text-xl">
                                {{ strtoupper(substr($category->name,0,1)) }}
                            </div>

                            <div>
                                <div class="text-sm font-semibold text-slate-900">{{ $category->name }}</div>
                                <div class="text-xs text-slate-500">{{ $category->products_count }} products</div>
                            </div>
                        </div>

                        <div class="flex gap-3">

                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="text-xs text-emerald-600 font-medium">Edit</a>

                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Delete category?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs text-red-600 font-medium">Delete</button>
                            </form>

                        </div>

                    </div>
                @endforeach
            </div>

        </div>
        <!-- Overview Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 space-y-4">
            <h2 class="text-lg font-semibold text-slate-900">Category Overview</h2>

            <p class="text-sm text-slate-500">
                Total categories: <strong>{{ $categories->count() }}</strong>
            </p>
        </div>

    </div>

</div>
@endsection
