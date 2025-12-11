@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')

@if(session('replaced'))
<script>
    // replace this page in browser history so back won't return to edit page
    history.replaceState(null, null, "{{ route('admin.products.index') }}");
</script>
@endif
<div class="space-y-6 max-w-6xl mx-auto">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.products.index') }}"
           class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Edit Product</h1>
            <p class="text-slate-500 mt-1">Update product information</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">

                <!-- Basic Info -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Basic Information</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm font-medium text-slate-700">Product Name</label>
                            <input type="text" name="name" value="{{ $product->name }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Category</label>
                            <select name="category_id"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        @selected($product->category_id == $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Price (LBP)</label>
                            <input type="number" step="0.01" name="price" value="{{ $product->price }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
                        </div>

                    </div>

                    <div>
                        <label class="text-sm font-medium text-slate-700">Description</label>
                        <textarea name="description" rows="4"
                                  class="w-full px-4 py-2.5 rounded-xl border border-slate-300">{{ $product->description }}</textarea>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Inventory</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm font-medium text-slate-700">Stock</label>
                            <input type="number" name="stock" value="{{ $product->stock }}"
                                   class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
                        </div>

                        <div>
        <label class="text-sm font-medium text-slate-700">Status</label>
        <select name="is_active" class="w-full px-4 py-2.5 rounded-xl border border-slate-300">
            <option value="1" @selected($product->is_active == 1)>Active</option>
            <option value="0" @selected($product->is_active == 0)>Inactive</option>
        </select>
    </div>

                    </div>
                </div>

            </div>

            <!-- Image -->
            <div class="space-y-6">

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-900 mb-3">Product Image</h2>

                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" class="w-full rounded-lg mb-3">
                    @endif

                    <input type="file" name="image" class="w-full text-sm">
                </div>

            </div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.products.index') }}"
               class="px-4 py-2.5 rounded-xl bg-slate-100">Cancel</a>

            <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white">
                Update Product
            </button>
        </div>

    </form>
</div>
@endsection
