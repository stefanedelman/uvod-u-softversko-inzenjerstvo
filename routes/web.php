<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// USE CASE 2.2.3: Kreiranje porudžbine
Route::post('/order', [OrderController::class, 'store']);

// USE CASE 2.2.2: Pregled i pretraga proizvoda
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/category/{category}', [ProductController::class, 'byCategory']);
Route::get('/products/{product}', [ProductController::class, 'show']);
