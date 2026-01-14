<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// =============================================
// PUBLIC ROUTES (Use Cases za kupce)
// =============================================

// USE CASE 2.2.2: Pregled i pretraga proizvoda
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/category/{category}', [ProductController::class, 'byCategory']);
Route::get('/products/{product}', [ProductController::class, 'show']);

// USE CASE 2.2.3: Kreiranje porudžbine
Route::post('/order', [OrderController::class, 'store']);

// Kategorije (public read)
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

// =============================================
// ADMIN ROUTES (Use Case 2.2.4 & 2.2.5)
// =============================================

// Admin: Upravljanje kategorijama
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{category}', [CategoryController::class, 'update']);
Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

// Admin: Upravljanje proizvodima (Use Case 2.2.4)
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

// Admin: Upravljanje porudžbinama (Use Case 2.2.5)
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{order}', [OrderController::class, 'show']);
Route::put('/orders/{order}', [OrderController::class, 'update']);

// Admin: Stavke porudžbine
Route::get('/orders/{order}/items', [OrderItemController::class, 'index']);
Route::post('/orders/{order}/items', [OrderItemController::class, 'store']);
