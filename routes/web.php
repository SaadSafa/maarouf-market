<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Models\Cart;

Route::get('/test-resend', function() {
    try {
        Mail::raw('Test email from Resend!', function($message) {
            $message->to('maaroufmarket@gmail.com')
                   ->subject('Resend Test');
        });
        return 'Email sent! Check your inbox.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard (auth landing)
Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Product details
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Public AJAX routes
Route::get('/ajax/products', [HomeController::class, 'ajaxProducts'])->name("ajax.products");
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Cart (guests and logged-in) — guarded by shop toggle
Route::middleware(['shop.open'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// Logged-in user routes
Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout (guarded by shop toggle)
    Route::middleware(['shop.open'])->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    });

    // User orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
});

// It loads login, register, password reset routes from Breeze.
require __DIR__.'/auth.php';
