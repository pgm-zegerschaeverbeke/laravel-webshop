<?php

use App\Http\Controllers\FavoriteController;
use Illuminate\Support\Facades\Route;

Route::prefix('favorites')->middleware('auth')->group(function () {
    Route::get('/', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

Route::get('/favorites/count', [FavoriteController::class, 'count'])->name('favorites.count');

