<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Product;

// trait is code die in meerdere classes kan worden gebruikt
trait ProcessesCookieCart
{
    // omzetten van ruwe cookie cart naar een array met volledige product info, subtotals voor elk item en totaal subtotaal
    protected function processCookieCartForDisplay(): array
    {
        return $this->processCookieCart(false);
    }

    // omzetten van ruwe cookie cart naar een array met product_id voor order creation
    protected function processCookieCartForOrder(): array
    {
        return $this->processCookieCart(true);
    }

    // functie om cookie cart te verwerken, met optie voor order format
    private function processCookieCart(bool $forOrder = false): array
    {
        // cart array ophalen via cookie
        $cookieCart = $this->getCartFromCookie();
        // cart items array aanmaken
        $cartItems = [];
        // subtotal aanmaken
        $subtotal = 0;

        // als cart niet leeg is, producten ophalen via array keys van in de cookie cart en indexeren via id
        if (!empty($cookieCart)) {
            $products = Product::whereIn('id', array_keys($cookieCart))
                ->get()
                ->keyBy('id');

            // voor elk item in cart, haalt product op en koppelt aan quantity, key wordt toegewezen aan $productId en value aan $quantity
            foreach ($cookieCart as $productId => $quantity) {
                // product ophalen via id uit products
                $product = $products->get($productId);
                // als product bestaat en beschikbaar is voor koop, subtotal berekenen en toevoegen aan cart items array
                if ($product && $product->isAvailableForPurchase()) {
                    $itemSubtotal = $product->price * $quantity;
                    $subtotal += $itemSubtotal;

                    // Voor order in db: product_id toevoegen, voor display in cart pagina: subtotal per item toevoegen
                    if ($forOrder) {
                        $cartItems[] = [
                            'product_id' => $productId,
                            'quantity' => $quantity,
                            'product' => $product,
                        ];
                    } else {
                        $cartItems[] = [
                            'product' => $product,
                            'quantity' => $quantity,
                            'subtotal' => $itemSubtotal,
                        ];
                    }
                }
            }
        }

        // array returnen met cart items en subtotal
        return ['cartItems' => $cartItems, 'subtotal' => $subtotal];
    }

    // functie om cart van cookie te ophalen en om te zetten naar een php array
    protected function getCartFromCookie(): array
    {
        // cookie cart ophalen via request
        $cartCookie = request()->cookie('shopping_cart');

        // als cookie cart bestaat, decodeen en returnen
        if ($cartCookie) {
            $cart = json_decode($cartCookie, true);
            // safety check om te kijken of de decoded cart een array is
            return is_array($cart) ? $cart : [];
        }

        // als cookie cart niet bestaat, lege array returnen
        return [];
    }
}

