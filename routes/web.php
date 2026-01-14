<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

// ============================================
// WEB RUTE (Frontend - Blade views)
// ============================================

Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/katalog', [WebController::class, 'katalog'])->name('katalog');
Route::get('/proizvod/{product}', [WebController::class, 'proizvod'])->name('proizvod');

// Korpa rute
Route::get('/korpa', [WebController::class, 'korpa'])->name('korpa');
Route::post('/korpa/dodaj/{product}', [WebController::class, 'dodajUKorpu'])->name('korpa.dodaj');
Route::delete('/korpa/ukloni/{product}', [WebController::class, 'ukloniIzKorpe'])->name('korpa.ukloni');
Route::get('/checkout', [WebController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [WebController::class, 'processCheckout'])->name('checkout.process');

// ============================================
// API RUTE (JSON responses)
// ============================================

// Products API
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

// Categories API
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

// Orders API
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{order}', [OrderController::class, 'show']);
Route::post('/order', [OrderController::class, 'store']);
Route::put('/orders/{order}', [OrderController::class, 'update']);
Route::delete('/orders/{order}', [OrderController::class, 'destroy']);

// Order Items API
Route::get('/order-items', [OrderItemController::class, 'index']);
Route::get('/order-items/{orderItem}', [OrderItemController::class, 'show']);
Route::post('/order-items', [OrderItemController::class, 'store']);
Route::put('/order-items/{orderItem}', [OrderItemController::class, 'update']);
Route::delete('/order-items/{orderItem}', [OrderItemController::class, 'destroy']);

// ============================================
// BREEZE AUTH RUTE
// ============================================

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// ADMIN PANEL RUTE
// ============================================

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Products CRUD
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

    // Categories CRUD
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/categories/create', [AdminController::class, 'createCategory'])->name('admin.categories.create');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/categories/{category}/edit', [AdminController::class, 'editCategory'])->name('admin.categories.edit');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'deleteCategory'])->name('admin.categories.delete');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::patch('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');

    // Users
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::patch('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('admin.users.toggle');
});

require __DIR__.'/auth.php';
