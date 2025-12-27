<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminSettingController;

// Admin routes (protected
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    // Admin dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Manage products
Route::get('/search-products', [AdminProductController::class, 'search_for_orders']);

Route::get('/products/search', [AdminProductController::class, 'Search'])->name('admin.products.search');

Route::post('products/{product}/update-status', [AdminProductController::class,'updateStatus'])
    ->name('admin.products.updateStatus');

    Route::resource('products', AdminProductController::class)
        ->names('admin.products');

    // Manage categories
    Route::resource('categories', AdminCategoryController::class)
        ->names('admin.categories');

    // Manage orders

    Route::get('/orders/pending-count', [AdminOrderController::class,'GetPendingOrders'])
    ->name('admin.orders.pendingCount');

    Route::resource('orders', AdminOrderController::class)
        ->names('admin.orders');
        
    Route::get('/orders-refresh',[AdminOrderController::class,'refreshOrder'])->name('admin.orders.refresh');;

    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');

    Route::get('/orders/{order}/items', [AdminOrderController::class, 'getItems'])
        ->name('admin.orders.items');
    Route::post('/orders/{order}/items/add', [AdminOrderController::class, 'addItem'])
        ->name('admin.orders.items.add');

    Route::patch('/orders/items/{item}/update', [AdminOrderController::class, 'updateItem'])
        ->name('admin.orders.items.update');

    Route::delete('/orders/items/{item}/delete', [AdminOrderController::class, 'deleteItem'])
        ->name('admin.orders.items.delete');
        
    // Manage sliders
    Route::resource('sliders', AdminSliderController::class)
        ->names('admin.sliders')
        ->parameters(['sliders' => 'offerSlider']);

    // Store toggle
    Route::post('/settings/store-toggle', [AdminSettingController::class, 'toggleShop'])
        ->name('admin.settings.store-toggle');


});
