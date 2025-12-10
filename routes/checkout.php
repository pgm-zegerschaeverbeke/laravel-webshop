<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'checkout'])->name('checkout.index');
    Route::post('/', [CheckoutController::class, 'checkoutSubmit'])->name('checkout.submit');
    Route::get('/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/webhook', [CheckoutController::class, 'webhook'])->name('checkout.webhook');
});

