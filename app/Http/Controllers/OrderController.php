<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
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

    public function cancel($id)
    {
        $order = Order::where('user_id', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        if($order->status != 'placed'){
            return response()->json([
                'success' => false,
                'message' => 'This order cannot be cancelled.'

            ],400);
        }

        $order->status = 'cancelled';
        $order->save();

        return response()->json([
            'success' => true,
            'newStatus' => 'cancelled',
            'badgeColor' => 'bg-red-600',
            'message' => 'Your order has been cancelled.'
        ]);

    }
}
