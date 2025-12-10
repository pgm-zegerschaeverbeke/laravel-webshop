<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Artesaos\SEOTools\Facades\SEOTools;

class HomeController extends Controller
{
    // toont homepage met featured products
    public function index()
    {
        SEOTools::setTitle('Only Scams | Premium Scam Products Store');
        SEOTools::setDescription('Scams So Good, They\'ll Want to Get Fooled Twice. Discover our premium collection of scam products online. Shop unique and exclusive scams today!');
        SEOTools::opengraph()->setUrl(route('home'));
        SEOTools::opengraph()->setType('website');
        SEOTools::opengraph()->addProperty('locale', app()->getLocale());
        SEOTools::jsonLd()->setType('WebSite');
        
        $featured = Product::query()
            ->available()
            ->featured()
            ->with(['images', 'category'])
            ->latest()
            ->get(['id', 'title', 'slug', 'price', 'category_id']);
    
        return view('home.index', compact('featured'));
    }
}