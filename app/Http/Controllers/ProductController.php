<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Artesaos\SEOTools\Facades\SEOTools;

class ProductController extends Controller
{
    // toont producten pagina met filters, search en paginatie
    public function index()
    {
        SEOTools::setTitle('All Products | Browse Our Scam Collection | Only Scams');
        SEOTools::setDescription('Browse our complete collection of premium scam products. Find the perfect scam for you! Shop exclusive scams online with fast delivery.');
        SEOTools::opengraph()->setUrl(route('products.index'));
        SEOTools::opengraph()->setType('website');
        SEOTools::jsonLd()->setType('CollectionPage');

        // producten ophalen die available zijn met filters, search en paginatie
        $products = Product::query()
            ->available()
            // als er categories filter bestaat, word callback uitgevoerd, is_array voor ook enkele waarde, whereIn heeft array nodig
            ->when(request('categories'), function ($query, $categories) {
                $query->whereIn('category_id', is_array($categories) ? $categories : [$categories]);
            })
            // zelfde als categories filter, maar voor brands
            ->when(request('brands'), function ($query, $brands) {
                $query->whereIn('brand_id', is_array($brands) ? $brands : [$brands]);
            })
            // als er een search query is, callback uitvoeren, where () groepering om condities van brands en categories niet te overschrijven, use search zodat search beschikbaar is in children scopes
            ->when(request('search'), function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%")
                      ->orWhereHas('brand', function($brandQuery) use ($search) {
                          $brandQuery->where('name', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('category', function($categoryQuery) use ($search) {
                          $categoryQuery->where('name', 'LIKE', "%{$search}%");
                      });
                });
            })
            ->paginate(9)
            // behoud query parameters in paginatie links
            ->withQueryString();

        // categories en brands ophalen en ordenen op name      
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        
        // checkt of het een ajax request is, in mijn geval vanuit de javascript product-filter.js
        if (request()->ajax()) {
            // returns json object met products grid, pagination en count, rendered content teruggegeven dus geen page reload
            return response()->json([
                // view (...) maakt een view object en render () rendert de view naar html
                'products' => view('products.partials.products-grid', compact('products'))->render(),
                'pagination' => view('products.partials.pagination', compact('products'))->render(),
                'count' => $products->total()
            ]);
        }
        
        // als geen ajax request is, toon de index pagina met products, categories en brands
        return view('products.index', compact('products', 'categories', 'brands'));
    }

    // toont product pagina met product details, related products en reviews
    public function show(Product $product)
    {
        // checkt of product beschikbaar is, normaal worden er geen producten meegegeven die niet beschikbaar zijn, dus dit is safety check
        if (!$product->isAvailableForPurchase()) {
            abort(404, 'Product not available');
        }

        // category en brand name ophalen
        $categoryName = $product->category->name ?? '';
        $brandName = $product->brand->name ?? '';
        
        // title met context: "Product Name | Category | Brand | Only Scams"
        $titleParts = array_filter([$product->title, $categoryName, $brandName, 'Only Scams']);
        SEOTools::setTitle(implode(' | ', $titleParts));
        
        $description = $product->description ?: "Buy {$product->title}" . ($categoryName ? " in {$categoryName}" : '') . " online. Premium quality scam product at €{$product->price}.";
        SEOTools::setDescription($description);
        SEOTools::opengraph()->setUrl(route('products.show', $product->slug));
        SEOTools::opengraph()->setType('product');
        SEOTools::opengraph()->setTitle($product->title);
        SEOTools::opengraph()->setDescription($description);
        
        // Add product image if available
        if ($product->primary_image_url) {
            $imageUrl = asset($product->primary_image_url);
            SEOTools::opengraph()->addImage($imageUrl);
            SEOTools::jsonLd()->addImage($imageUrl);
        }
        
        // Structured Data (JSON-LD) for Product
        SEOTools::jsonLd()->setType('Product');
        SEOTools::jsonLd()->setTitle($product->title);
        SEOTools::jsonLd()->setDescription($product->description ?: 'View product details and add to cart.');
        SEOTools::jsonLd()->addValue('price', number_format($product->price, 2, '.', ''));
        SEOTools::jsonLd()->addValue('priceCurrency', 'EUR');

        // haalt 3 related products op met zelfde category limit 3, exclusief het huidige product
        $relatedProducts = $product->getRelatedProducts(3);

        // haalt reviews op met user informatie, ordered by newest first, paginated
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(5)
            // behoud query parameters in paginatie links
            ->withQueryString()
            // voegt #reviews toe aan de url zodat je direct naar de reviews sectie kunt scrollen
            ->fragment('reviews');
        
        // toont product pagina met product details, related products en reviews
        return view('products.show', compact('product', 'relatedProducts', 'reviews'));
    }
}