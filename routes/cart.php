<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::prefix('cart')->group(function () {
    Route::get('/count', [CartController::class, 'count'])->name('cart.count');
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove', [CartController::class, 'remove'])->name('cart.remove');
});

