<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['admin']);
    }

    public function index()
    {
        $categories = Category::all(); 
        $products = Product::with('category')
            ->when(request()->q, function ($query) {
                $query->where('name', 'like', '%' . request()->q . '%');
            })
            ->latest()
            ->paginate(15);

        return view('admin.products.index', compact('products','categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $imageRule = 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048|dimensions:max_width=2000,max_height=2000';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lte:price',
            'stock' => 'nullable|integer|min:0',
            'barcode' => ['nullable', 'string', 'max:64', Rule::unique('products', 'barcode')],
            'description' => 'nullable|string',
            'image' => $imageRule,
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->storeAs(
                'products',
                Str::uuid()->toString() . '.' . $request->file('image')->getClientOriginalExtension(),
                'public'
            );
        }

        $product = Product::create($validated);

        Log::info('Admin product created', [
            'admin_id' => auth()->id(),
            'product_id' => $product->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('replaced', true)
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $imageRule = 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048|dimensions:max_width=2000,max_height=2000';

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lte:price',
            'stock' => 'required|integer|min:0',
            'is_active' => 'required|boolean',
            'image' => $imageRule,
            'barcode' => ['nullable', 'string', 'max:64', Rule::unique('products', 'barcode')->ignore($product->id)],
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request->file('image')->storeAs(
                'products',
                Str::uuid()->toString() . '.' . $request->file('image')->getClientOriginalExtension(),
                'public'
            );
        }

        $product->update($validated);

        Log::info('Admin product updated', [
            'admin_id' => auth()->id(),
            'product_id' => $product->id,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('replaced', true)
            ->with('success', 'Product updated successfully');
    }

   public function updateStatus(Request $request, Product $product)
{
    $validated = $request->validate([
        'is_active' => 'required|boolean'
    ]);

    $product->update($validated);

    return response()->json([
        'success' => true,
        'status' => $product->is_active
    ]);
}


    public function destroy(Product $product, Request $request)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $productId = $product->id;
        $product->delete();

        Log::warning('Admin product deleted', [
            'admin_id' => auth()->id(),
            'product_id' => $productId,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }

public function Search(Request $request)
{
    $categories = Category::all();
    $query = Product::query();
    //sorting for price 0$
    if ($request->filled('sort') && $request->catid !== '0') {
        $query->where('price', 0);
    }

      // Filter by ctaegory
    if ($request->filled('catid') && $request->catid !== 'All Categories') {
        $query->where('category_id', $request->catid);
    }

    //Filter by status
    if ($request->filled('status') && $request->status !== 'All status') {
        $query->where('is_active', $request->status === 'active' ? 1 : 0);
    }

    $products = $query->latest()->paginate(10);

    return view('admin.products.index', compact('products','categories'));
}


public function search_for_orders(Request $request)
{
    $term = $request->q;

    return Product::where('name', 'LIKE', "%$term%")
        ->orderBy('name')
        ->take(10)
        ->get();
}

}
