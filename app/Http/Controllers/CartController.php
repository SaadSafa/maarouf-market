<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = $cart->items()->with('product')->get();

        return view('frontend.cart', compact('cart', 'items'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $quantity = $request->input('quantity', 1);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // if already exists the update qty
        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $product->id)
                        ->first();

        if($item){
            $item->quantity += $quantity;
            $item->save();
        }else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', 'Item added to cart!');
    }

    public function update(Request $request, $id)
    {
        $item = CartItem::findOrFail($id);
        $item->quantity = $request->quantity;
        $item->save();

        return back();
    }

    public function remove($id)
    {
        CartItem::findOrFail($id)->delete();

        return back();
    }
}
