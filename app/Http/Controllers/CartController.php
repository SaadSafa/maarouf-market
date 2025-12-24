<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->activeCart($request);
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

        $cart = $this->activeCart($request);

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

        $item = $this->findCartItem($request, $id);
        $item->quantity = $validated['quantity'];
        $item->save();

        return response()->json([
            'lineTotal' => number_format($item->quantity * $item->price_at_time, 0)
        ]);
    }

    public function remove(Request $request, $id)
    {
        $item = $this->findCartItem($request, $id);
        $item->delete();

        //return updated cart count
        $cart = $this->activeCart($request);
        $newCount = $cart ? $cart->items()->count() : 0;

        return response()->json(['success' => true, 'cartCount' => $newCount]);
    }

    //function for updating the cart count badge
    public function count(Request $request)
    {
        $cart = $this->activeCart($request)->loadCount('items');

        return response()->json([
            'cartCount' => $cart->items_count ?? 0,
        ]);
    }

    private function findCartItem(Request $request, $id): CartItem
    {
        $cart = $this->activeCart($request);

        return $cart->items()->where('id', $id)->firstOrFail();
    }

    private function activeCart(Request $request): Cart
    {
        $sessionId = $request->session()->getId();

        if (Auth::check()) {
            $userCart = Cart::where('user_id', Auth::id())->first();
            $sessionCart = Cart::where('session_id', $sessionId)->first();

            if ($userCart && $sessionCart && $userCart->id !== $sessionCart->id) {
                // Merge session cart into user cart
                foreach ($sessionCart->items as $sessionItem) {
                    $existing = $userCart->items()
                        ->where('product_id', $sessionItem->product_id)
                        ->first();

                    if ($existing) {
                        $existing->quantity += $sessionItem->quantity;
                        $existing->save();
                    } else {
                        $sessionItem->cart_id = $userCart->id;
                        $sessionItem->save();
                    }
                }

                $sessionCart->delete();
            } elseif (!$userCart && $sessionCart) {
                // Reuse guest cart for logged-in user
                $sessionCart->user_id = Auth::id();
                $sessionCart->save();
                $userCart = $sessionCart;
            }

            if ($userCart) {
                if (!$userCart->session_id) {
                    $userCart->session_id = $sessionId;
                    $userCart->save();
                }
                return $userCart;
            }

            return Cart::create([
                'user_id' => Auth::id(),
                'session_id' => $sessionId,
            ]);
        }

        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }
}
