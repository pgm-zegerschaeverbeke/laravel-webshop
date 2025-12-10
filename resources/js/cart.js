// Cookie helper functions om waarde van specifieke cookie op te halen
import { showToast } from './toast';

function getCookie(name) {
    const nameEq = name + "=";
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        cookie = cookie.trim();
        if (cookie.indexOf(nameEq) === 0) {
            return decodeURIComponent(cookie.substring(nameEq.length));
        }
    }
    return "";
}

// Cart helper function om cart uit cookie te halen en om te zetten naar een JavaScript object
export function getCartFromCookie() {
    // waarde van cookie 'shopping_cart' ophalen
    const cartCookie = getCookie('shopping_cart');
    // als cookie niet bestaat, lege object returnen
    if (!cartCookie) return {};
    // als cookie bestaat, JSON.parse gebruiken om te zetten naar een JavaScript object '{"1":2,"5":1}' → {1: 2, 5: 1}
    try {
        return JSON.parse(cartCookie);
    } catch {
        // als JSON.parse mislukt, lege object returnen
        return {};
    }
}

// functie om cart count in header te updaten
export function updateCartCountInHeader(count) {
    document.querySelectorAll('[data-cart-count]').forEach($badge => {
        $badge.textContent = count;
    });
}

// haalt CSRF token uit meta tag in head van html in layout.blade.php
export function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
}

// valideert product en quantity en voegt product toe aan cart via API als user logged in is, anders aan cookie cart
export async function addToCart(productId, quantity) {
    try {
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ product_id: productId, quantity })
        });

        const data = await response.json();
        
        // als API call succesvol is, cart count in header updaten en toast notification tonen
        if (data.success) {
            updateCartCountInHeader(data.count);
            
            // toast notification tonen met melding of 1 of meerdere items toegevoegd zijn
            const message = quantity === 1 
                ? 'Item added to cart' 
                : `${quantity} items added to cart`;
            showToast('cart', message);
            
            return { success: true, count: data.count };
        }
        
        return { success: false };
    } catch (error) {
        console.error('Error adding to cart:', error);
        return { success: false };
    }
}

// Maak addToCart globaal beschikbaar zodat Alpine.js componenten (zoals cartData) de functie kunnen aanroepen
// Alpine.js heeft geen toegang tot ES6 module scope, dus moet via window beschikbaar zijn
window.addToCart = addToCart;

// Alpine.js component factory functie via x-data="cartData({{ $product->id }})" voor op een product detail pagina die een object returnt met state + methods voor quantity controls
window.cartData = function(productId) {
    return {
        // x-text="quantity" default = 1
        quantity: 1,
        adding: false,
        productId: productId,
        decreaseQuantity() {
            if (this.quantity > 1) {
                this.quantity--;
            }
        },
        increaseQuantity() {
            this.quantity++;
        },
        async addToCartAction() {
            this.adding = true;
            try {
                await addToCart(this.productId, this.quantity);
                this.quantity = 1;
            } finally {
                this.adding = false;
            }
        }
    };
};

// Alpine.js functie weer via x-data die verschillende data + methods meegeeft dewe keer in de cart page
window.cartItemData = function(productId, initialQuantity, price) {
    return {
        quantity: initialQuantity,
        updating: false,
        productId: productId,
        price: price,
        decreaseQuantity() {
            if (this.quantity > 1) {
                this.quantity--;
                this.updateCart();
            }
        },
        increaseQuantity() {
            this.quantity++;
            this.updateCart();
        },
        // stuurt nieuwe quantity naar de server 
        async updateCart() {
            this.updating = true;
            try {
                const response = await fetch('/cart/update', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({ product_id: this.productId, quantity: this.quantity })
                });

                const data = await response.json();
                
                // als succes
                if (data.success) {
                    // cart count in header updaten
                    updateCartCountInHeader(data.count);
                    // event uitzenden naar naar cart summary component die ernaar luistert via @cart-item-updated.window="updateTotals()" om de summary up te daten
                    window.dispatchEvent(new CustomEvent('cart-item-updated', {
                        detail: { productId: this.productId, quantity: this.quantity }
                    }));
                }
            } catch (error) {
                console.error('Error updating cart:', error);
            } finally {
                this.updating = false;
            }
        },
        // item uit cart verwijderen via API
        async removeItem() {        
            try {
                const response = await fetch('/cart/remove', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken()
                    },
                    body: JSON.stringify({ product_id: this.productId })
                });

                const data = await response.json();
                
                // als succes
                if (data.success) {
                    // cart count in header updaten
                    updateCartCountInHeader(data.count);
                    // pagina herladen om cart summary component opnieuw te renderen voor wijzigingen in de summary en indien leeg de empty message te tonen
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error removing item:', error);
            }
        }
    };
};

// Alpine.js component factory gebruikt in de cart summary om te luisteren naar event dat uitgezonden wordt door cartItemData component wanneer een item gewijzigd wordt @cart-item-updated.window="updateTotals()"
// word geberuikt om zonder refresh de summary up te daten
window.orderSummary = function(initialSubtotal) {
    return {
        subtotal: initialSubtotal,
        get tax() {
            return this.subtotal * 0.21;
        },
        get total() {
            return this.subtotal + this.tax;
        },
        updateTotals() {
            let newSubtotal = 0;
            // pak alle cartItems
            document.querySelectorAll('[x-data*="cartItemData("]').forEach($element => {
                // haal Alpine.js data op van het cartItem
                const data = Alpine.$data($element);
                if (!data?.productId || !data?.quantity || !data?.price) return;
                
                // Bereken subtotal: price * quantity
                newSubtotal += data.price * data.quantity;
            });
            // subtotal van alle cartItems
            this.subtotal = newSubtotal;
        }
    };
};

// pagina word geladen en standaard 0, na page load word de cart count opgehaald via API en in header getoond anders blijft 0 staan
async function loadCartCount() {
    try {
        const response = await fetch('/cart/count', {
            headers: { 'Accept': 'application/json' }
        });
        
        if (response.ok) {
            const data = await response.json();
            updateCartCountInHeader(data.count);
        }
    } catch (error) {
        console.warn('Could not fetch cart count from server:', error);
    }
}

document.addEventListener('DOMContentLoaded', loadCartCount);

