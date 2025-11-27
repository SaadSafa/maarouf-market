<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $order = Order::where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('frontend.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
                        ->where('id', $id)
                        ->with('items.product')
                        ->firstOrFail();

        return view('frontend.order-details', compact('order'));
    }
}
