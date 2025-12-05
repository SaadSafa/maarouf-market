<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\OfferSlider;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function index(Request $request)
    {

        //Search
        $search = $request->input('search');

        if($search){
            // Filter products by name or description
            $products = Product::where('name', 'LIKE', "%$search")
                                ->orWhere('description', 'LIKE', "%$search")
                                ->paginate(20);
        }else {
            // Default latest products
            $products = Product::latest()->paginate(20); 
        }

        // Load Category
        $categories = Category::where('is_active', 1)->get();

        //Load slider images
        $sliders = OfferSlider::where('is_active', 1)->get();

        return view('frontend.home', compact('products','categories', 'sliders', 'search'));
    }
}
