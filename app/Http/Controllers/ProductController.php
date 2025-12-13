<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::where('id', $id)
                          //->where('is_active', 1) //show a sold out badge instead of hiding the product
                          ->firstOrFail();

        // Related products from same cateogry
        $related = Product::where('category_id', $product->category_id)
                            ->where('id', '!=', $product->id)
                            ->where('is_active', 1)
                            ->limit(6)
                            ->get();

        return view('frontend.product', compact('product', 'related'));
    }
}
