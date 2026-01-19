<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-pwa="true">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

    <!-- SEO Meta Tags -->
    <title>{{ config('app.name') }}</title>
    <script src="{{ asset('home') }}/assets/js/theme-switcher.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('logo') }}/logo.png" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('logo') }}/logo.png">

    <!-- Preloaded local web font (Inter) -->
    <link rel="preload" href="{{ asset('home') }}/assets/fonts/inter-variable-latin.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Font icons -->
    <link rel="preload" href="{{ asset('home') }}/assets/icons/cartzilla-icons.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('home') }}/assets/icons/cartzilla-icons.min.css">

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('home') }}/assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('home') }}/assets/vendor/simplebar/dist/simplebar.min.css">
    <link rel="stylesheet" href="{{ asset('home') }}/assets/styles/choices.min.css">

    <!-- Bootstrap + Theme styles -->
    <link rel="preload" href="{{ asset('home') }}/assets/css/theme.min.css" as="style">
    {{-- <link rel="preload" href="{{ asset('home') }}/assets/css/theme.rtl.min.css" as="style"> --}}
    <link rel="stylesheet" href="{{ asset('home') }}/assets/css/theme.min.css" id="theme-styles">
</head>
