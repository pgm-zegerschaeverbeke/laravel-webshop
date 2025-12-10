<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'qty', 'unit_price'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // subtotal berekenen voor een enkel cart item
    public function getSubtotal(): float
    {
        return $this->unit_price * $this->qty;
    }

    // checkt of het product bestaat en beschikbaar is voor koop
    public function isValid(): bool
    {
        return $this->product && $this->product->isAvailableForPurchase();
    }
}
