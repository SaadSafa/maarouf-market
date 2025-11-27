<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Related products from same cateogry
        $related = Product::where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->limit(6)
                            ->get();

        return view('frontend.product', compact('product', 'related'));
    }
}
