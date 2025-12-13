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
        $categoryId = $request->filled('category')
            ? (int) $request->input('category')
            : null;

        // Load active categories
        $categories = Category::where('is_active', 1)->get();

        // If category isn't valid, ignore it
        if ($categoryId && ! $categories->contains('id', $categoryId)) {
            $categoryId = null;
        }

        // Load active sliders
        $sliders = OfferSlider::where('is_active', 1)->get();

        // Product query
        //$query = Product::where('is_active', 1);
        //change query to get all products adding sold out badge
        $query = Product::query();

        // Filter by category
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Filter by search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Pagination order by active products
        //$products = $query->latest()->paginate(10);
        $query->orderBy('is_active', 'desc')
                ->orderBy('id', 'desc');

        $products = $query->paginate(10);


        return view('frontend.home', compact(
            'products',
            'categories',
            'sliders',
            'search',
            'categoryId'
        ));
    }
}
