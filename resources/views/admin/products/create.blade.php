@extends('admin.layouts.app')

@section('title', 'Create Product')

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
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 19l-7-7 7-7"/>
            </svg>
        </a>

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Create Product</h1>
            <p class="text-slate-500 mt-1">Add a new product to your catalog</p>
        </div>
    </div>


    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left section -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Basic Information</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Product Name</label>
                            <input 
                                type="text" 
                                name="name"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm text-slate-800 focus:ring-2 focus:ring-emerald-500" 
                                required>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Category</label>
                            <select 
                                name="category_id"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-emerald-500"
                                required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">SKU</label>
                            <input 
                                type="text" 
                                name="barcode"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-emerald-500">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Price (LBP)</label>
                            <input 
                                type="number" 
                                name="price"
                                step="0.01"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-emerald-500"
                                required>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="text-sm font-medium text-slate-700">Description</label>
                        <textarea 
                            name="description"
                            rows="4"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-emerald-500"></textarea>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 space-y-4">
                    <h2 class="text-lg font-semibold text-slate-900">Inventory</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-slate-700">Stock Quantity</label>
                            <input 
                                type="number" 
                                name="stock"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-emerald-500"
                                required>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-slate-700">Status</label>
                            <select 
                                name="status"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-emerald-500">
                                <option value="active">Active</option>
                                <option value="draft">Draft</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right section -->
            <div class="space-y-6">
                <!-- Image Upload -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Product Image</h2>

                    <input 
                        type="file" 
                        name="image"
                        class="block w-full text-sm text-slate-700">
                </div>
            </div>
        </div>

        <!-- Bottom buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.products.index') }}"
               class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 text-sm font-medium hover:bg-slate-200">
                Cancel
            </a>

            <button 
                type="submit"
                class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white text-sm font-medium hover:bg-emerald-700 shadow-sm shadow-emerald-200">
                Save Product
            </button>
        </div>
    </form>
</div>
@endsection
