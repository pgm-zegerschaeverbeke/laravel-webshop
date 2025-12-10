<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const TAX_RATE = 0.21;

    protected $fillable = [
        'number',
        'user_id',
        'status',
        'subtotal',
        'tax_total',
        'grand_total',
        'shipping_name',
        'shipping_email',
        'shipping_address',
        'shipping_postal_code',
        'shipping_city',
        'shipping_country',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // tax berekenen voor een order
    public static function calculateTax(float $subtotal): float
    {
        return $subtotal * self::TAX_RATE;
    }

    // total berekenen voor een order
    public static function calculateTotal(float $subtotal): float
    {
        return $subtotal + self::calculateTax($subtotal);
    }

    // unieke order nummer genereren ORD- gevolgd door datum en willekeurige 6 cijfers
    public static function generateOrderNumber(): string
    {
        // loop tot een unieke order nummer gevonden is, als nummer al bestaat, genereer een nieuwe, als uniek is stopt loop
        do {
            $orderNumber = 'ORD-' . now()->format('Y-m-d') . '-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('number', $orderNumber)->exists());

        return $orderNumber;
    }

    // order aanmaken van cart data, shipping data en user id (als user niet ingelogd is, user id is null)
    public static function createFromCartData(array $cartData, array $shippingData, ?int $userId = null): self
    {
        // total berekenen adhv cart data (subtotal) + tax
        $subtotal = $cartData['subtotal'];
        $tax = self::calculateTax($subtotal);
        $total = self::calculateTotal($subtotal);

        // order aanmaken
        $order = self::create([
            'number' => self::generateOrderNumber(),
            'user_id' => $userId,
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax_total' => $tax,
            'grand_total' => $total,
            'shipping_name' => $shippingData['name'],
            'shipping_email' => $shippingData['email'],
            'shipping_address' => $shippingData['address'],
            'shipping_postal_code' => $shippingData['postal_code'],
            'shipping_city' => $shippingData['city'],
            'shipping_country' => $shippingData['country'],
        ]);

        // order items aanmaken koppel aan order via order_id slaat product, hoeveelheid, prijs en regel-totaal op
        foreach ($cartData['cartItems'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'qty' => $item['quantity'],
                'unit_price' => $item['product']->price,
                'line_total' => OrderItem::calculateLineTotalFor($item['product']->price, $item['quantity']),
            ]);
        }

        return $order;
    }

    // bepaalt shipping name, als user ingelogd is dan first en last name combineren via getFullName(), als niet ingelogd dan name van form input
    public static function getShippingName(?User $user = null, ?string $name = null): string
    {
        // als user ingelogd is, gebruik getFullName() van User model (berekent first_name + last_name, niet name want die is overschreven door Filament)
        if ($user) {
            return $user->getFullName();
        }

        // als geen user (guest checkout), gebruik naam uit form
        return $name ?? '';
    }

    // formatteert order items voor display op thank you pagina
    public function getItemsForDisplay(): array
    {
        // map de order items naar een array met title, quantity, price en subtotal (via toDisplayArray() van OrderItem model) dus alleen array met nodige data
        return $this->items->map(fn($item) => $item->toDisplayArray())->toArray();
    }
}
