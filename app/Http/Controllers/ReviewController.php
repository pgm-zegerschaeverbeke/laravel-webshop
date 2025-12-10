<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // validatie voor review data, body mag leeg zijn 
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'body' => 'nullable|string',
        ]);

        // product ophalen via product id
        $product = Product::findOrFail($validated['product_id']);

        // review aanmaken
        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'title' => $validated['title'],
            'body' => $validated['body'] ?? null,
        ]);


        // redirect naar de product page review sectie met success message
        return redirect()
            ->route('products.show', $product->slug)
            ->with('success', 'Review submitted successfully!')
            ->withFragment('reviews');
    }
}

