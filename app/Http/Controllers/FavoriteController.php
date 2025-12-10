<?php

namespace App\Http\Controllers;

use App\Models\Product;

class FavoriteController extends Controller
{
    // geeft count terug voor favorites bij logged in user
    public function count()
    {
        // als user niet logged in is, count 0 teruggeven, normaal kan dit nooit gebeuren omdat er geen favorites zijn bij niet ingelogde users maar als safety
        if (!auth()->check()) {
            return response()->json(['count' => 0]);
        }
        
        // als user logged in is, count ophalen via getFavoriteCount functie in user model
        $count = auth()->user()->getFavoriteCount();
        return response()->json(['count' => $count]);
    }

    // toont favorites pagina
    public function index()
    {
        // als user niet logged in is, redirect naar login pagina, normaal kan dit nooit gebeuren omdat er geen favorites zijn bij niet ingelogde users maar als safety
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // als user logged in is, favorieten van de user en die available zijn ophalen
        $favorites = auth()->user()->getAvailableFavorites();

        // favorites meesturen naar view
        return view('favorites.index', compact('favorites'));
    }

    // wisselt favoriet status van product
    public function toggle(Product $product)
    {
        // als user niet logged in is, error 401 teruggeven, normaal kan dit nooit gebeuren omdat er geen favorites zijn bij niet ingelogde users maar als safety
        if (!auth()->check()) {
            return response()->json(['error' => 'You must be logged in to favorite products'], 401);
        }

        // user ophalen
        $user = auth()->user();

        // favoriet status wisselen
        $isFavorited = $user->toggleFavorite($product);

        // nieuwe count ophalen
        $count = $user->getFavoriteCount();

        return response()->json([
            'isFavorited' => $isFavorited,
            'count' => $count,
        ]);
    }
}

