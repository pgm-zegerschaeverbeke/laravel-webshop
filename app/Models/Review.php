<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'rating', 'title', 'body'];

    protected $casts = [
        'rating' => 'integer',
    ];

    // valideren van rating bij opslaan van review
    protected static function boot()
    {
        parent::boot();

        // valideren van rating bij opslaan van review
        static::saving(function ($review) {
            if ($review->rating < 1 || $review->rating > 5) {
                throw ValidationException::withMessages([
                    'rating' => 'The rating must be between 1 and 5.',
                ]);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
