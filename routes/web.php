<?php

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

require __DIR__.'/auth.php';
