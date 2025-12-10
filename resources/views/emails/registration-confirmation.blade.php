<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome!</title>
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
        .welcome-message {
            font-size: 18px;
            color: #433c35;
            margin-bottom: 20px;
            font-weight: 500;
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
        ul {
            color: #433c35;
            margin: 20px 0;
            padding-left: 20px;
        }
        li {
            margin: 10px 0;
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
            <h1>Welcome to {{ config('app.name', 'our website') }}!</h1>
        </div>

        <div class="content">
            <div class="welcome-message">
                Hello {{ $user->first_name ?? $user->name }},
            </div>

            <p>Thank you for registering with us! We're excited to have you on board.</p>

            <p>Your account has been successfully created. You can now:</p>
            <ul>
                <li>Browse our products</li>
                <li>Add items to your cart</li>
                <li>Save your favorite products</li>
                <li>Track your orders</li>
            </ul>

            <div class="button-container">
                <a href="{{ route('products.index') }}" class="button">Start Shopping</a>
            </div>

            <p>If you have any questions or need assistance, please don't hesitate to contact us.</p>

            <p>Best regards,<br>The {{ config('app.name', 'Laravel') }} Team</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
