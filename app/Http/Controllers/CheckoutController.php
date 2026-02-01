<?php

namespace App\Http\Controllers;

use App\Mail\PhoneOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

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

    public function verifyPhoneOtp(Request $request)
{
    $request->validate([
        'otp' => 'required'
    ]);

     $user = User::find(Auth::id());

    if (
        $user->phone_otp !== $request->otp ||
        now()->gt($user->phone_otp_expires_at)
    ) {
        return back()->withErrors(['otp' => 'Invalid or expired code']);
    }

    $user->update([
        'phone_verified_at' => now(),
        'phone_otp' => null,
        'phone_otp_expires_at' => null,
    ]);

    return redirect()->route('home');
}


    public function sendPhoneOtp(Request $request)
{
    $request->validate([
        'customer_phone' => 'required|unique:users,phone,' . Auth::id()
    ]);

    $user = User::find(Auth::id());

    $otp = strval(rand(100000, 999999));

    $user->update([
        'phone' => $request->customer_phone,
        'phone_otp' => $otp,
        'phone_otp_expires_at' => now()->addMinutes(10),
    ]);

    Mail::to($user->email)->send(new PhoneOtpMail($otp));

    return redirect()->route('phone.verify.page');
}

    public function confirm(Request $request)
    {
        
        $validated = $request->validate([
    'customer_name' => auth()->user()->phone_verified_at ? ['nullable','string','max:255'] : ['required','string','max:255'],
    'customer_phone' => auth()->user()->phone_verified_at ? ['nullable','string','max:8'] : ['required','string','max:8'],
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
             $user = User::find(Auth::id());
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $user->phone_verified_at 
            ? $user->name 
            : $validated['customer_name'],
        'customer_phone' => $user->phone_verified_at 
            ? $user->phone 
            : $validated['customer_phone'],
            'address' => $validated['address'] ?? null,
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
// Check if the customer phone is different from the user's phone
if (!auth()->user()->phone_verified_at) {
    // Update phone, address, and location with new values
    $user->update([
        'phone' => auth()->user()->phone_verified_at ? null : $validated['customer_phone'],
        'address' => $validated['address'],
        'location' => $validated['area'],
    ]);
}
           // Clear cart
            $cart->items()->delete();

            return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
        });
    }

}
