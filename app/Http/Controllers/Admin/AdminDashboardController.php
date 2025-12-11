<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;

class AdminDashboardController extends Controller
{
    public function __construct()
{
    $this->middleware('admin');
}

    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalOrders = Order::count();
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())->sum('total');
        $monthRevenue = Order::whereMonth('created_at', now()->month)->sum('total');
        $recentOrders = Order::latest()->take(8)->get();
        $lowStock = Product::where('stock', '<=', 5)->orderBy('stock')->take(5)->get();
        $ProductChangePercentage = Product::monthlyChanged();
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'todayOrders',
            'todayRevenue',
            'monthRevenue',
            'recentOrders',
            'lowStock',
            'ProductChangePercentage'
        ));
    }
}
