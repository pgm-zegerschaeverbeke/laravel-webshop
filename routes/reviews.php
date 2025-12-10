<?php

use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::post('/reviews', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');

