<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->with('items.product')
                    ->first();

        return view('frontend.checkout', compact('cart'));
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $cart = Cart::where('user_id', Auth::id())
                    ->with('items.product')
                    ->first();

        if(!$cart || $cart->items()->count() == 0){
            return back()->with('error', 'Your cart is empty.');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'full_name' => $validated['full_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'location' => $validated['location'] ?? null,
            'note' => $validated['note'] ?? null,
            'status' => 'pending',
            'total_price' => $cart->items->sum(fn($i) => $i->quantity * $i->product->price),
        ]);

        foreach($cart->items as $item){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price_at_time' => $item->product->price,
            ]);
        }

        // Clear cart
        $cart->items()->delete();

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }
}
