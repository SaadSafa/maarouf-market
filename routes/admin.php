<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminSliderController;

// Admin routes (protected
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Admin dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Manage products
    Route::resource('products', AdminProductController::class);

    // Manage categories
    Route::resource('categories', AdminCategoryController::class);

    // Manage orders
    Route::resource('orders', AdminOrderController::class);

    // Manage sliders (offers)
    Route::resource('sliders', AdminSliderController::class);
});
