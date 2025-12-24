<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
    @foreach($products as $product)
        <x-product-card :product="$product" />
    @endforeach
</div>

@if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endif
