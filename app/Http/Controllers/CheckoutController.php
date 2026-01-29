<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        if (! Auth::user()->hasVerifiedEmail()) {
    return redirect()->route('verification.notice')
        ->with('warning', 'Please verify your email before checkout.');
}

        $cart = Cart::where('user_id', Auth::id())
                    ->with('items.product')
                    ->first();

        return view('frontend.checkout', compact('cart'));
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'area' => ['required', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->with('items.product')
                    ->first();

        if(!$cart || $cart->items()->count() == 0){
            return back()->with('error', 'Your cart is empty.');
        }

        //checkout relies on each cart item's stored price_at_time snapshot
        $orderTotal = $cart->items->sum(function($item){
            $price = $item->price_at_time ?? $item->product->effective_price;
            return $item->quantity * $price;
        });

        return DB::transaction(function () use ($validated, $cart, $orderTotal) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $validated['customer_name'],
                'customer_phone' => $validated['customer_phone'],
                'address' => $validated['address'],
                'area' => $validated['area'] ?? null,
                'note' => $validated['note'] ?? null,
                'status' => 'placed',
                'total' => $orderTotal,
                //'total' => $cart->items->sum(fn($i) => $i->quantity * $i->product->price),
            ]);

            foreach ($cart->items as $item) {
                $priceSnapshot = $item->price_at_time ?? $item->product->effective_price;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $priceSnapshot,
                    //'price' => $item->product->price,
                ]);
            }

            // Clear cart
            $cart->items()->delete();

            return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
        });
    }
}
