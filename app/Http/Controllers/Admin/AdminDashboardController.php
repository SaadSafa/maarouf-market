<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
use DB;

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
        $monthRevenue = Order::whereMonth('created_at', now()->month)
    ->whereYear('created_at', now()->year) 
    ->where('status', '!=', 'cancelled') // exclude cancelled orders
    ->sum('total');

        $recentOrders = Order::latest()->take(8)->get();
        $lowStock = Product::where('stock', '<=', 5)->orderBy('stock')->take(5)->get();
        $ProductChangePercentage = Product::monthlyChanged();


         $revenueByDay = DB::table('orders')
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as revenue')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
        ->where('status', '!=', 'cancelled') // exclude cancelled orders
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy('date', 'ASC')
        ->get()
        ->keyBy('date');
    
    // Generate all 7 days (fill missing days with 0)
    $labels = [];
    $data = [];
    
    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i);
        $dateKey = $date->format('Y-m-d');
        $dayName = $date->format('D'); // Mon, Tue, Wed...
        
        $labels[] = $dayName;
        $data[] = $revenueByDay->has($dateKey) 
            ? (float) $revenueByDay[$dateKey]->revenue 
            : 0;
    }
    
    $revenueData = [
        'labels' => $labels,
        'data' => $data
    ];
        
        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'todayOrders',
            'todayRevenue',
            'monthRevenue',
            'recentOrders',
            'lowStock',
            'ProductChangePercentage',
            'revenueData'
        ));
    }
}
