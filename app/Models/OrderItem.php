<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'qty', 'unit_price', 'line_total'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // berekent regel-totaal voor een order item in de createFromCartData functie van Order model
    public static function calculateLineTotalFor(float $unitPrice, int $quantity): float
    {
        return $unitPrice * $quantity;
    }

    // formatteert order items voor display op thank you pagina, enkel array met nodige data
    public function toDisplayArray(): array
    {
        return [
            'title' => $this->product->title,
            'quantity' => $this->qty,
            'price' => $this->unit_price,
            'subtotal' => $this->line_total,
        ];
    }
}
