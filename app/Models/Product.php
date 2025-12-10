<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

class Product extends Model implements Sitemapable
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'is_available',
        'is_featured',
        'category_id',
        'brand_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // scope voor alleen beschikbare producten avalaible() in query builder
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    // scope voor alleen featured producten featured() in query builder
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // accessor die een dynamische property toevoegt aan het product model, returned een string of null, voegt een nieuwe field toe met naam primary_image_url
    public function getPrimaryImageUrlAttribute(): ?string
    {
        // als er een primaire image bestaat, return de url
        $primary = $this->images()->where('is_primary', true)->first();
        if ($primary) {
            return $primary->url;
        }
        
        // als er geen primaire image bestaat, return de url van de eerste image
        $first = $this->images()->first();
        return $first ? $first->url : null;
    }

    // maakt de sitemap url object aan, word automatisch aangeroepen door de route sitemap, voor elk product een url object aanmaken
    public function toSitemapTag(): Url
    {
        return Url::create(route('products.show', $this->slug))
            ->setLastModificationDate($this->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(1.0);
    }

    // checkt of het product beschikbaar is voor koop
    public function isAvailableForPurchase(): bool
    {
        return (bool) $this->is_available;
    }

    // ophalen van gerelateerde producten op basis van category, alleen beschikbare producten, huidige product excluderen en max 3 producten
    public function getRelatedProducts(int $limit = 3)
    {
        return self::query()
            ->available()
            ->where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->limit($limit)
            ->get();
    }
}
