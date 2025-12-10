<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    // invulbare velden
    protected $fillable = ['name', 'slug'];

    // relatie met products, een brand kan meerdere products hebben
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
