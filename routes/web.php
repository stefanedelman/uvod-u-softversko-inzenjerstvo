<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Ruta za kreiranje porudžbine (Use Case: Kreiranje porudžbine)
Route::post('/order', [OrderController::class, 'store']);
