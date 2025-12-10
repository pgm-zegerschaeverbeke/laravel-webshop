<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    // invulbare velden
    protected $fillable = ['user_id', 'status'];

    // relatie met user, een cart behoort tot een user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relatie met cart items, een cart kan meerdere cart items hebben
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // subtotal berekenen voor alle beschikbare items in cart
    public function getSubtotal(): float
    {
        // isValid checkt of het item beschikbaar is voor koop
        // sum berekent de som van de subtotals van alle beschikbare items
        return $this->items
            ->filter(fn($item) => $item->isValid())
            ->sum(fn($item) => $item->getSubtotal());
    }

    // cart items ophalen voor display op cart pagina
    public function getItemsForDisplay(): array
    {
        return $this->getItemsFormatted(false);
    }

    // cart items ophalen voor order creation
    public function getItemsForOrder(): array
    {
        return $this->getItemsFormatted(true);
    }

    // formatteren van cart items voor display of order creation
    private function getItemsFormatted(bool $forOrder = false): array
    {
        return $this->items
            ->filter(fn($item) => $item->isValid())
            // use forOrder om beschikbaar te maken in de callback functie en vervolgens de juiste format te returnen
            ->map(function ($item) use ($forOrder) {
                if ($forOrder) {
                    return [
                        'product_id' => $item->product_id,
                        'quantity' => $item->qty,
                        'product' => $item->product,
                    ];
                }
                return [
                    'product' => $item->product,
                    'quantity' => $item->qty,
                    'subtotal' => $item->getSubtotal(),
                ];
            })
            // values() zorgt ervoor dat de keys van de array opnieuw worden ingesteld op 0, 1, 2
            ->values()
            // omzetten naar array
            ->toArray();
    }

    // cart leegmaken en status updated naar checked_out
    public function clear(): void
    {
        $this->items()->delete();
        $this->update(['status' => 'checked_out']);
    }

    // haalt active cart voor een user op, of maakt er een aan als er nog geen bestaat
    public static function getOrCreateActiveForUser(int $userId): self
    {
        // eerste array van paramaters is zoeken, tweede array is voor aanmaken als er niets gevonden wordt
        return self::firstOrCreate(
            ['user_id' => $userId, 'status' => 'active'],
            ['user_id' => $userId, 'status' => 'active']
        );
    }

    // // haalt active cart op voor user met items en producten, null als niet gevonden
    public static function getActiveForUser(int $userId): ?self
    {
        return self::where('user_id', $userId)
            ->where('status', 'active')
            ->with('items.product')
            ->first();
    }
}
