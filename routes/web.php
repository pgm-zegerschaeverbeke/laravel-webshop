<?php

use App\Http\Controllers\HomeController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

// Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Load route files
require __DIR__ . '/products.php';
require __DIR__ . '/cart.php';
require __DIR__ . '/checkout.php';
require __DIR__ . '/reviews.php';
require __DIR__ . '/favorites.php';
require __DIR__ . '/auth.php';

// Sitemap route
Route::get('/sitemap', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create(route('home'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(1.0))
        ->add(Url::create(route('products.index'))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority(0.9))
        ->add(Product::available()->get());

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return response()->file(public_path('sitemap.xml'));
})->name('sitemap');