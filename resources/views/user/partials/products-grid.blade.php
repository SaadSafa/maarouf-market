<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4" data-products-grid>
    @foreach($products as $product)
        <x-product-card :product="$product" />
    @endforeach
</div>

@if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-4" data-pagination data-next-url="{{ $products->nextPageUrl() ?? '' }}">
        {{ $products->links() }}
    </div>
@endif

<div class="mt-4 hidden text-center text-sm text-slate-500" data-products-loader>
    Loading more products...
</div>

<div data-products-sentinel class="h-1"></div>
