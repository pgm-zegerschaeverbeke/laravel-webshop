<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'DM Sans', Arial, sans-serif;
            line-height: 1.6;
            color: #433c35;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #e8e0d2;
        }
        .container {
            background-color: #f9f7f3;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            border-bottom: 2px solid #c3af9f;
            padding-bottom: 20px;
            margin-bottom: 30px;
            text-align: center;
        }
        .logo {
            max-width: 120px;
            height: auto;
            margin-bottom: 15px;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            color: #433c35;
            margin: 0;
            font-size: 32px;
            font-weight: bold;
        }
        .order-number {
            color: #8c4630;
            font-size: 14px;
            margin-top: 5px;
            font-weight: 500;
        }
        .order-details {
            margin-bottom: 30px;
        }
        .order-items {
            margin: 20px 0;
        }
        .order-item {
            padding: 15px;
            border-bottom: 1px solid #c3af9f;
            display: flex;
            justify-content: space-between;
            background-color: #fff;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .item-name {
            font-weight: 600;
            color: #433c35;
        }
        .item-details {
            color: #8c4630;
            font-size: 14px;
            margin-top: 5px;
        }
        .totals {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #c3af9f;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            color: #433c35;
        }
        .total-row.grand-total {
            font-size: 20px;
            font-weight: bold;
            color: #433c35;
            border-top: 2px solid #8c4630;
            padding-top: 15px;
            margin-top: 10px;
        }
        .shipping-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-top: 30px;
            border: 1px solid #c3af9f;
        }
        .shipping-info h2 {
            font-family: 'Playfair Display', serif;
            margin-top: 0;
            color: #433c35;
            font-size: 20px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #c3af9f;
            text-align: center;
            color: #c3af9f;
            font-size: 12px;
        }
        h2 {
            font-family: 'Playfair Display', serif;
            color: #433c35;
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0 10px 0;
        }
        p {
            color: #433c35;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ config('app.url') }}/favicon/favicon-96x96.png" alt="{{ config('app.name', 'Laravel') }}" class="logo">
            <h1>Order Confirmation</h1>
            <div class="order-number">Order #{{ $order->number }}</div>
        </div>

        <div class="order-details">
            <p>Thank you for your order! We've received your order and will process it shortly.</p>

            <div class="order-items">
                <h2>Order Items</h2>
                @foreach($order->items as $item)
                    <div class="order-item">
                        <div>
                            <div class="item-name">{{ $item->product->title }}</div>
                            <div class="item-details">Quantity: {{ $item->qty }} × €{{ number_format($item->unit_price, 2, '.', ',') }}</div>
                        </div>
                        <div style="font-weight: 600; color: #433c35;">€{{ number_format($item->line_total, 2, '.', ',') }}</div>
                    </div>
                @endforeach
            </div>

            <div class="totals">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>€{{ number_format($order->subtotal, 2, '.', ',') }}</span>
                </div>
                <div class="total-row">
                    <span>Tax (21%):</span>
                    <span>€{{ number_format($order->tax_total, 2, '.', ',') }}</span>
                </div>
                <div class="total-row grand-total">
                    <span>Total:</span>
                    <span>€{{ number_format($order->grand_total, 2, '.', ',') }}</span>
                </div>
            </div>
        </div>

        <div class="shipping-info">
            <h2>Shipping Address</h2>
            <p>
                <strong>{{ $order->shipping_name }}</strong><br>
                {{ $order->shipping_address }}<br>
                {{ $order->shipping_postal_code }} {{ $order->shipping_city }}<br>
                {{ $order->shipping_country }}
            </p>
        </div>

        <div class="footer">
            <p>If you have any questions about your order, please contact us.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
