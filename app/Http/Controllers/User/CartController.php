<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $this->activeCart($request);
        $items = $cart->items()->with('product')->get();

        return view('user.frontend.cart', compact('cart', 'items'));
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
                'price_at_time' => $product->effective_price,
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
        $cartToken = $request->cookie('cart_token');

        if (Auth::check()) {
            $userCart = Cart::where('user_id', Auth::id())->first();
            $sessionCart = Cart::where('session_id', $sessionId)->first();
            $tokenCart = $cartToken
                ? Cart::where('cart_token', $cartToken)->first()
                : null;

            // Merge carts into user cart
            if (!$userCart) {
                $userCart = $tokenCart ?: $sessionCart;
                if ($userCart) {
                    $userCart->user_id = Auth::id();
                    $userCart->session_id = $sessionId;
                    $userCart->save();
                } else {
                    $userCart = Cart::create([
                        'user_id' => Auth::id(),
                        'session_id' => $sessionId,
                    ]);
                }
            } else {
                // Merge session cart
                if ($sessionCart && $userCart->id !== $sessionCart->id) {
                    $this->mergeCarts($sessionCart, $userCart);
                    $sessionCart->delete();
                }
                // Merge token cart
                if ($tokenCart && $userCart->id !== $tokenCart->id) {
                    $this->mergeCarts($tokenCart, $userCart);
                    $tokenCart->delete();
                }
                // Ensure session id is current
                if ($userCart->session_id !== $sessionId) {
                    $userCart->session_id = $sessionId;
                    $userCart->save();
                }
            }

            // Clear guest cart token cookie after merge
            Cookie::queue(Cookie::forget('cart_token'));

            return $userCart;
        }

        // Guest: use cart_token first, then session_id
        $cart = null;
        if ($cartToken) {
            $cart = Cart::where('cart_token', $cartToken)->first();
        }
        if (!$cart) {
            $cart = Cart::where('session_id', $sessionId)->first();
        }

        if (!$cart) {
            $cart = Cart::create([
                'session_id' => $sessionId,
                'cart_token' => Str::uuid()->toString(),
            ]);
        } elseif (!$cart->cart_token) {
            $cart->cart_token = Str::uuid()->toString();
            $cart->save();
        }

        // Keep cart token in cookie so cart survives session regeneration
        Cookie::queue(cookie()->forever('cart_token', $cart->cart_token));

        return $cart;
    }

    private function mergeCarts(Cart $from, Cart $into): void
    {
        foreach ($from->items as $sessionItem) {
            $existing = $into->items()
                ->where('product_id', $sessionItem->product_id)
                ->first();

            if ($existing) {
                $existing->quantity += $sessionItem->quantity;
                $existing->save();
            } else {
                $sessionItem->cart_id = $into->id;
                $sessionItem->save();
            }
        }
    }
}
