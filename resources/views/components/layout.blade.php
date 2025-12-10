<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon/favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon/favicon-96x96.png') }}" sizes="96x96">
    <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <meta name="apple-mobile-web-app-title" content="OnlyScams">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

    {!! SEO::generate() !!}

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Alpine.js - Load after our scripts -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body id="top" class="font-sans bg-background text-primary px-4 min-h-screen flex flex-col">
    <x-header />
    <x-toast />

    {{ $slot }}

    <x-footer />
    <a href="#top" aria-label="Back to top">
        <x-heroicon-o-arrow-up-circle
            class="w-15 h-15 fixed bottom-4 right-4 text-primary hover:text-accent transition-colors duration-300 ease-out cursor-pointer" />
    </a>

    @include('cookie-consent::index')
</body>

</html>