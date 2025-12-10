<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Newsletter</title>
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
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 18px;
            color: #433c35;
            margin-bottom: 20px;
            font-weight: 500;
        }
        .products-section {
            margin: 30px 0;
        }
        .products-section h2 {
            font-family: 'Playfair Display', serif;
            color: #433c35;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .product-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #c3af9f;
        }
        .product-title {
            font-weight: 600;
            color: #433c35;
            font-size: 18px;
            margin-bottom: 8px;
        }
        .product-description {
            color: #8c4630;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .product-price {
            font-size: 20px;
            font-weight: bold;
            color: #8c4630;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #8c4630;
            color: #fff7e9;
            text-decoration: none;
            border-radius: 9999px;
            margin: 20px 0;
            font-weight: 500;
            transition: background-color 0.3s ease;
            text-align: center;
        }
        .button:hover {
            background-color: #7f3e2c;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #c3af9f;
            text-align: center;
            color: #c3af9f;
            font-size: 12px;
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
            <h1>Weekly Newsletter</h1>
        </div>

        <div class="content">
            <div class="greeting">
                Hello {{ $user->first_name ?? $user->name }},
            </div>

            <p>We hope you're having a great week! Here are some featured products we think you might love:</p>

            <div class="products-section">
                <h2>Featured Products</h2>
                @foreach($featuredProducts as $product)
                    <div class="product-item">
                        <div class="product-title">{{ $product->title }}</div>
                        <div class="product-description">{{ Str::limit($product->description, 100) }}</div>
                        <div class="product-price">€{{ number_format($product->price, 2, '.', ',') }}</div>
                    </div>
                @endforeach
            </div>

            <div class="button-container">
                <a href="{{ route('products.index') }}" class="button">View All Products</a>
            </div>

            <p>Thank you for being a valued customer!</p>

            <p>Best regards,<br>The {{ config('app.name', 'Laravel') }} Team</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

