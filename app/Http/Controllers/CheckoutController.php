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
        $cart = Cart::where('user_id', Auth::id())
                    ->with('items.product')
                    ->first();

        if(!$cart || $cart->items()->count() == 0){
            return back()->with('error', 'Your cart is empty.');
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'address' => $request->address,
            'phone' => $request->phone,
            'location' => $request->location,
            'note' => $request->note,
            'status' => 'pending',
            'total' => $cart->items->sum(fn($i) => $i->quantity * $i->product->price),
        ]);

        foreach($cart->items as $item){
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Clear cart
        $cart->items()->delete();

        return redirect()->route('order.index')->with('success', 'Order placed successfully!');
    }
}
