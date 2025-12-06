@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
@if(session('replaced'))
<script>
    // replace this page in browser history so back won't return to edit page
    history.replaceState(null, null, "{{ route('admin.products.index') }}");
</script>
@endif


<div class="space-y-6">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Products</h1>
            <p class="text-slate-500 mt-1">Manage your product catalog</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm shadow-emerald-200">
            <span class="text-lg leading-none">+</span>
            <span>Add Product</span>
        </a>
    </div>

    <div class="flex flex-col sm:flex-row gap-4">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
            </svg>
           <form action="{{ route('admin.products.index') }}" method="GET">
    <input
        type="text"
        name="q"
        onkeyup="this.form.submit()"
        value="{{ request('q') }}"
        placeholder="Search by name or SKU..."
        class="w-full h-10 pl-10 pr-4 rounded-xl border border-slate-200 bg-white text-sm"
    />
</form>

        </div>
        <div class="flex gap-2">
            <select
                class="h-10 px-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/70">
                <option>All categories</option>
            </select>
            <form method="GET" action="{{ route('admin.products.search') }}">
            <select name="status"
             onchange="this.form.submit()"
                class="h-10 px-3 rounded-xl border border-slate-200 bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/70">
                <option value="All status" {{ request('status') =='All status'?'selected':'' }}>All status</option>
                <option value="active" {{ request('status')==='active' ? 'selected':'' }}>Active</option>
                <option value="inactive" {{ request('status')=== 'inactive'? 'selected':'' }}>In Active</option>
                </select>
                </form>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-left text-xs text-slate-500">
                        <th class="py-3 px-4">Product</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Price</th>
                        <th class="py-3 px-4">Stock</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-slate-100 overflow-hidden flex items-center justify-center text-xs text-slate-400">
                                        @if ($product->image)
    <img src="{{ asset('storage/' . $product->image) }}" 
         alt="{{ $product->name }}" 
         class="h-full w-full object-cover">
@else
    IMG
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-slate-900">{{ $product->name }}</div>
                                        <div class="text-xs text-slate-500">SKU: {{ $product->sku ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-slate-700">{{ $product->category->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-slate-900">{{ number_format($product->price, 2) }} LBP</td>
                            <td class="py-3 px-4 text-slate-700">{{ $product->stock }}</td>
                            <td class="py-3 px-4">
                                <span 
    class="btnstatus cursor-pointer inline-flex items-center px-2 py-1 rounded-full text-xs
        {{ $product->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700' }}"
    data-id="{{ $product->id }}"
    data-status="{{ $product->is_active }}"
>
    {{ $product->is_active ? 'In Stock' : 'Out of Stock' }}
</span>

                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="inline-flex items-center gap-2">
                                    
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                       class="text-xs text-emerald-600 hover:text-emerald-700 font-medium">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                          onsubmit="return confirm('Delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-xs text-red-600 hover:text-red-700 font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400 text-sm">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($products, 'links'))
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
