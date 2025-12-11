<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
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
        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($id);
        $quantity = $validated['quantity'] ?? 1;

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
                'price_at_time' => $product->price,
            ]);
        }

        return response()->json([
            'success' => true,
            'cartCount' => $cart->items()->count(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $item = $this->findUserCartItem($id);
        $item->quantity = $validated['quantity'];
        $item->save();

        return response()->json([
            'lineTotal' => number_format($item->quantity * $item->price_at_time, 0)
        ]);
    }

    public function remove($id)
    {
        $item = $this->findUserCartItem($id);
        $item->delete();

        //return updated cart count
        $cart = Cart::where('user_id', Auth::id())->first();
        $newCount = $cart ? $cart->items()->count() : 0;

        return response()->json(['success' => true, 'cartCount' => $newCount]);
    }

    //function for updating the cart count badge
    public function count()
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->withCount('items')
                    ->first();

        return response()->json([
            'cartCount' => $cart?->items_count ?? 0,
        ]);
    }

    private function findUserCartItem($id): CartItem
    {
        return CartItem::where('id', $id)
            ->whereHas('cart', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();
    }
}
