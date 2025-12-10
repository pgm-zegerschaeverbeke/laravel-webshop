<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'url', 'alt_text', 'is_primary'];

    // code om file te verwijderen bij deleten van product image, zodat er geen onnodige files op de server blijven staan
    protected static function boot()
    {
        parent::boot();

        // Delete the file when the model is deleted
        static::deleting(function ($productImage) {
            if ($productImage->url) {
                // Remove 'storage/' prefix if present to get the actual file path
                $filePath = str_replace('storage/', '', $productImage->url);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }
        });
    }

    // accessor die ervoor zorgt dat de url altijd begint met 'storage/' zodat de asset helper kan werken
    public function getUrlAttribute($value)
    {
        // als er geen url is, return 
        if (!$value) {
            return $value;
        }
        
        // als de url al begint met 'storage/' dan return de url als is
        if (str_starts_with($value, 'storage/')) {
            return $value;
        }
        
        // voegt 'storage/' prefix toe aan de url als het nog niet bestaat, eigenlijk voor Filament uploads is
        return 'storage/' . $value;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
