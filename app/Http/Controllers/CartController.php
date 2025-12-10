<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ProcessesCookieCart;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

// compact() kan je een string aan meegeven met de namen van de variabelen die je wilt meesturen naar de view ipv bv ['cartItems' => $cartItems, 'subtotal' => $subtotal]
class CartController extends Controller
{
    use ProcessesCookieCart;
    // aantal items in winkelwagen weergeven, als user logged in is met count van items uit db, anders met count van items uit cookie
    public function count()
    {
        if (auth()->check()) {
            $cart = Cart::getActiveForUser(auth()->id());
            $count = $cart ? $cart->items->count() : 0;
        } else {
            $cookieCart = $this->getCartFromCookie();
            $count = count($cookieCart);
        }
        
        return response()->json(['count' => $count]);
    }

    // winkelwagen pagina weergeven, als user logged in is met items uit db, anders met items uit cookie
    public function index()
    {
        if (auth()->check()) {
            $cart = Cart::getActiveForUser(auth()->id());
            $cartItems = $cart ? $cart->getItemsForDisplay() : [];
            $subtotal = $cart ? $cart->getSubtotal() : 0;
        } else {
            $cartData = $this->processCookieCartForDisplay();
            $cartItems = $cartData['cartItems'];
            $subtotal = $cartData['subtotal'];
        }
        
        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    // product toevoegen aan cart
    public function add(Request $request)
    {
        // Validatie en product check
        $errorResponse = $this->validateProductRequest($request);
        if ($errorResponse) {
            return $errorResponse;
        }
        
        [$product, $quantity] = $this->getProductAndQuantity($request);

        // als user logged in is, cart ophalen of aanmaken
        if (auth()->check()) {
            // cart ophalen, indien niet bestaat, cart aanmaken en items laden via eager loading: laadt alle items en gerelateerde producten in 1 keer
            $cart = Cart::getOrCreateActiveForUser(auth()->id());

            // items van cart laden en product meegeven
            $cart->load('items.product');
            
            // Controleren of product al in cart zit
            $cartItem = $cart->items()->where('product_id', $product->id)->first();
            
            // als item bestaat, hoeveelheid toevoegen en prijs bijwerken
            if ($cartItem) {
                $cartItem->qty += $quantity;
                $cartItem->unit_price = $product->price;
                $cartItem->save();
            } else {
                // als item niet bestaat, item aanmaken
                $cart->items()->create([
                    'product_id' => $product->id,
                    'qty' => $quantity,
                    'unit_price' => $product->price,
                ]);
            }

            // cart refreshen en items laden
            $cart->refresh();
            $cart->load('items');
            return response()->json(['success' => true, 'count' => $cart->items->count()]);
        } else {
            // als user niet logged in is,
            // cart ophalen via cookie
            $cart = $this->getCartFromCookie();
            // als product al in cart zit, quantity verhogen, anders zet quantity op nieuwe waarde
            $cart[$product->id] = ($cart[$product->id] ?? 0) + $quantity;

            // Cookie updaten + count terugsturen
            return response()->json(['success' => true, 'count' => count($cart)])
                ->cookie($this->makeCartCookie($cart));
        }
    }

    // hoeveelheid updaten van product in cart
    public function update(Request $request)
    {
        // Validatie en product check
        $errorResponse = $this->validateProductRequest($request);
        if ($errorResponse) {
            return $errorResponse;
        }
        
        [$product, $quantity] = $this->getProductAndQuantity($request);

        // als user logged in is, cart ophalen
        if (auth()->check()) {
            // cart ophalen
            $cart = Cart::getActiveForUser(auth()->id());
            $cart->load('items.product');
           
            // zoekt juiste item
            $cartItem = $cart->items->where('product_id', $product->id)->first();
            
            // quantity updaten en opslaan in db
            $cartItem->qty = $quantity;
            $cartItem->save();
            
            // cart refreshen, herladen van items en json return met count van items in cart
            $cart->refresh();
            $cart->load('items');
            return response()->json(['success' => true, 'count' => $cart->items->count()]);
        } else {
            // als user niet logged in is, cart ophalen via cookie
            $cart = $this->getCartFromCookie();
            // quantity voor dat product in de array updaten
            $cart[$product->id] = $quantity;

            // json return met count van items in cart en cookie updaten
            return response()->json(['success' => true, 'count' => count($cart)])
                ->cookie($this->makeCartCookie($cart));
        }
    }

    // product verwijderen uit cart
    public function remove(Request $request)
    {
        // Validatie en product check
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // product id ophalen uit request
        $productId = $request->product_id;

        // als user logged in is, cart ophalen
        if (auth()->check()) {
            // cart ophalen
            $cart = Cart::getActiveForUser(auth()->id());
            // als cart bestaat, items verwijderen met product id
            if ($cart) {
                $cart->items()->where('product_id', $productId)->delete();
                $cart->refresh();
                $cart->load('items');
            }

            // json return met count van aantal items in cart, indien cart bestaat, anders 0
            return response()->json(['success' => true, 'count' => $cart ? $cart->items->count() : 0]);
        } else {
            // als user niet logged in is, cart array ophalen via cookie
            $cart = $this->getCartFromCookie();
            // product uit cart array verwijderen
            unset($cart[$productId]);

            // json return met count van items in cart en cookie updaten
            return response()->json(['success' => true, 'count' => count($cart)])
                ->cookie($this->makeCartCookie($cart));
        }
    }

    // product en quantity valideren en product ophalen en controleren of het beschikbaar is
    private function validateProductRequest(Request $request)
    {
        // Validatie
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        // Product ophalen en controleren of het beschikbaar is
        $product = Product::find($request->product_id);
        if (!$product || !$product->isAvailableForPurchase()) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available'
            ], 400);
        }

        return null; // geen error
    }

    // product en quantity ophalen uit request
    private function getProductAndQuantity(Request $request): array
    {
        $product = Product::find($request->product_id);
        $quantity = (int) $request->quantity;
        
        return [$product, $quantity];
    }

    // cart cookie aanmaken met proper settings voor JavaScript access
    private function makeCartCookie(array $cart)
    {
        return Cookie::make(
            'shopping_cart', 
            json_encode($cart), 
            60 * 24 * 30, // 30 days
            '/', // path
            null, // domain
            null, // secure (will use config)
            false, // httpOnly - MUST be false for JavaScript access
            false, // raw
            'lax' // sameSite
        );
    }

}

