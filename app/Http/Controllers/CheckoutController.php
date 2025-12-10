<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ProcessesCookieCart;
use App\Mail\OrderConfirmationMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use Mollie\Api\MollieApiClient;

class CheckoutController extends Controller
{
    use ProcessesCookieCart;
    // checkout pagina weergeven
    public function checkout()
    {
        // cart data ophalen
        $cartData = $this->getCartDataForCheckout();

        // als cart items empty is, redirect naar cart pagina met error, normaal nooit maar voor safety
        if (empty($cartData['cartItems'])) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // subtotal gelijkstellen aan subtotal uit cart data
        $subtotal = $cartData['subtotal'];
        // tax berekenen adhv subtotal
        $tax = Order::calculateTax($subtotal);
        // total berekenen adhv subtotal
        $total = Order::calculateTotal($subtotal);

        return view('order.checkout.index', [
            'cartItems' => $cartData['cartItems'],
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total
        ]);
    }

    /**
     * Handle checkout form submission and create Mollie payment
     */
    public function checkoutSubmit(Request $request)
    {
        // validation rules voor shipping data
        $validationRules = [
            'address' => 'required|string|max:500',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
        ];

        // als user niet logged in is, validation rules voor name en email toevoegen
        if (!auth()->check()) {
            $validationRules['name'] = 'required|string|max:255';
            $validationRules['email'] = 'required|email|max:255';
        }

        // validatie uitvoeren
        $request->validate($validationRules);

        // cart data ophalen voor order creatie
        $cartData = $this->getCartDataForOrder();

        // als cart items empty is, redirect naar cart pagina met error, normaal nooit maar voor safety
        if (empty($cartData['cartItems'])) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // name en email ophalen van user account indien user logged in is, anders van form inputs
        $user = auth()->user();
        $name = Order::getShippingName($user, $request->input('name'));
        $email = $user ? $user->email : $request->input('email');

        // shipping data aanmaken met name, email, address, postal code, city en country
        $shippingData = [
            'name' => $name,
            'email' => $email,
            'address' => $request->input('address'),
            'postal_code' => $request->input('postal_code'),
            'city' => $request->input('city'),
            'country' => $request->input('country'),
        ];

        // order aanmaken met cart data, shipping data en user id
        $order = Order::createFromCartData($cartData, $shippingData, auth()->id());

        // payment aanmaken bij mollie, geeft MolliePayment object terug met checkout url
        $molliePayment = $this->createMolliePayment($order, $order->grand_total);

        // payment info opslaan in db, payment linken aan order, status op pending om nadien up te daten via de webhook maar in dit geval via de success.
        Payment::create([
            'order_id' => $order->id,
            'provider' => 'mollie',
            'mollie_payment_id' => $molliePayment->id,
            'status' => 'pending',
            'amount' => $order->grand_total,
        ]);

        // cart clearen
        $this->clearCart();

        // redirect naar mollie checkout url
        return redirect($molliePayment->getCheckoutUrl(), 303);
    }

    // success callback van mollie
    public function success(Request $request)
    {
        // order id ophalen uit query parameter
        $orderId = $request->query('order_id');

        // als order id niet bestaat, redirect naar cart pagina met error, normaal nooit maar voor safety
        if (!$orderId) {
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        // order ophalen uit db met items en payment relaties
        $order = Order::with('items.product', 'payment')->find($orderId);

        // als order niet bestaat of payment niet bestaat, redirect naar cart pagina met error, normaal nooit maar voor safety
        if (!$order || !$order->payment) {
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        // mollie payment ophalen via mollie api
        $molliePayment = $this->getMollieClient()->payments->get($order->payment->mollie_payment_id);
        // payment status updaten adhv mollie payment
        $this->updatePaymentStatus($order->payment, $molliePayment);

        // als payment betaald is, order status updaten naar paid en order confirmation email versturen
        if ($molliePayment->isPaid()) {
            // order status updaten naar paid
            $order->update(['status' => 'paid']);

            // laad relaties voor email en verstuurd email met order confirmation
            $order->load('items.product');
            Mail::to($order->shipping_email)->send(new OrderConfirmationMail($order));

            // thank you pagina weergeven met order details
            return view('order.thank-you.thank-you', [
                'orderNumber' => $order->number,
                'orderItems' => $order->getItemsForDisplay(),
                'subtotal' => $order->subtotal,
                'tax' => $order->tax_total,
                'total' => $order->grand_total,
                'shippingName' => $order->shipping_name,
                'shippingEmail' => $order->shipping_email,
                'shippingAddress' => $order->shipping_address,
                'shippingPostalCode' => $order->shipping_postal_code,
                'shippingCity' => $order->shipping_city,
                'shippingCountry' => $order->shipping_country,
            ]);
        }

        // als payment niet betaald is, redirect naar cart pagina met error, gebruiker kan opnieuw proberen
        return redirect()->route('cart.index')->with('error', 'Payment not completed.');
    }

    // webhook van mollie om payment status te updaten, momenteel niet in gebruik maar voor als de site live zou gaan lol lol
    public function webhook(Request $request)
    {
        $paymentId = $request->input('id');

        if (!$paymentId) {
            return response()->json(['error' => 'Payment ID not provided'], 400);
        }

        $payment = Payment::where('mollie_payment_id', $paymentId)->first();

        if (!$payment || !$payment->order) {
            return response()->json(['error' => 'Payment or order not found'], 404);
        }

        $molliePayment = $this->getMollieClient()->payments->get($paymentId);
        $this->updatePaymentStatus($payment, $molliePayment);

        if ($molliePayment->isPaid()) {
            $payment->order->update(['status' => 'paid']);

            $order = $payment->order->load('items.product');
            Mail::to($order->shipping_email)->send(new OrderConfirmationMail($order));
        }

        return response()->json(['success' => true]);
    }

    // functie om cart data voor checkout te ophalen
    private function getCartDataForCheckout(): array
    {
        return $this->getCartData(false);
    }

    // functie om cart data voor order creatie te ophalen
    private function getCartDataForOrder(): array
    {
        return $this->getCartData(true);
    }

    // functie om cart data te ophalen, met optie voor order/checkout format
    private function getCartData(bool $forOrder = false): array
    {
        // als user logged in is, cart ophalen via db
        if (auth()->check()) {
            // cart ophalen via db
            $cart = Cart::getActiveForUser(auth()->id());
            // als cart bestaat, return geformatteerde cart items en totale prijs voor alle items in cart zonder tax
            if ($cart) {
                return [
                    'cartItems' => $forOrder ? $cart->getItemsForOrder() : $cart->getItemsForDisplay(),
                    'subtotal' => $cart->getSubtotal(),
                ];
            }
        } else {
            // als user niet logged in is, cookie cart ophalen en verwerken
            return $forOrder ? $this->processCookieCartForOrder() : $this->processCookieCartForDisplay();
        }

        // fallback als user logged in is maar geen cart bestaat, lege array returnen
        return ['cartItems' => [], 'subtotal' => 0];
    }

    // maakt en configureert een Mollie API-client voor betalingstransacties.
    private function getMollieClient(): MollieApiClient
    {
        // nieuwe instantie van Mollie api client
        $mollie = new MollieApiClient();

        // api key instellen via config
        $mollie->setApiKey(config('services.mollie.key'));

        // geeft geconfigureerde client terug
        return $mollie;
    }

    // functie om nieuwe mollie payment aan te maken, order object en totaal prijs meegeven
    private function createMolliePayment(Order $order, float $total)
    {
        // maakt mollie payment aan, geeft MolliePayment object terug
        return $this->getMollieClient()->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format($total, 2, '.', ''),
            ],
            'description' => 'Order #' . $order->number,
            'redirectUrl' => route('checkout.success', ['order_id' => $order->id]),
            'webhookUrl' => route('checkout.webhook'),
            'metadata' => ['order_id' => $order->id],
        ]);
    }

    // update payment status id database adhv mollie payment status
    private function updatePaymentStatus(Payment $payment, $molliePayment): void
    {
        // als payment betaald is, completed, als niet betaald is en is failed, failed, anders pending
        $payment->update([
            'status' => $molliePayment->isPaid() ? 'completed' : ($molliePayment->isFailed() ? 'failed' : 'pending'),
        ]);
    }

    // leegt cart na checkout, indien user logged in is clear cart in db, anders cookie cart wissen/leegmaken
    private function clearCart(): void
    {
        // als user logged in is, cart in db leegmaken
        if (auth()->check()) {
            // cart in db ophalen via user id
            $cart = Cart::getActiveForUser(auth()->id());
            // als cart bestaat, leegmaken
            if ($cart) {
                // cart leegmaken
                $cart->clear();
            }
        } else {
            // als user niet logged in is, cookie cart wissen/leegmaken, queue om later toe te voegen aan response, door cookie met dezelfde naam een expiration van -1 te geven verwijdert de browser de cookie automatisch 
            Cookie::queue(Cookie::make('shopping_cart', '', -1, '/', null, null, false, false, 'lax'));
        }
    }
}

