<!DOCTYPE html>
<html lang="en" data-bs-theme="light" data-pwa="true">
<head>
    <meta charset="utf-8">

    <!-- Viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover">

    <!-- SEO Meta Tags -->
    <title>{{ config('app.name') }} | Authentication</title>

    <!-- Webmanifest + Favicon / App icons -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="manifest" href="manifest.json">
    <link rel="icon" type="image/png" href="{{ asset('logo') }}/logo.png" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('logo') }}/logo.png">

    <!-- Theme switcher (color modes) -->
    <script src="{{ asset('home') }}/assets/js/theme-switcher.js"></script>

    <!-- Preloaded local web font (Inter) -->
    <link rel="preload" href="{{ asset('home') }}/assets/fonts/inter-variable-latin.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Font icons -->
    <link rel="preload" href="{{ asset('home') }}/assets/icons/cartzilla-icons.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('home') }}/assets/icons/cartzilla-icons.min.css">

    <!-- Bootstrap + Theme styles -->
    <link rel="preload" href="{{ asset('home') }}/assets/css/theme.min.css" as="style">
    <link rel="preload" href="{{ asset('home') }}/assets/css/theme.rtl.min.css" as="style">
    <link rel="stylesheet" href="{{ asset('home') }}/assets/css/theme.min.css" id="theme-styles">

    {{-- Sweetalert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>


  <!-- Body -->
  <body>
    @include('sweetalert2')

    <!-- Page content -->
    <main class="content-wrapper w-100 px-3 ps-lg-5 pe-lg-4 mx-auto" style="max-width: 1920px">
        <div class="d-lg-flex">

            <!-- Login form + Footer -->
            <div class="d-flex flex-column min-vh-100 w-100 py-4 mx-auto me-lg-5" style="max-width: 416px">

                <!-- Logo -->
                <header class="navbar px-0 pb-4 mt-n2 mt-sm-0 mb-2">
                    <a href="index.html" class="navbar-brand pt-0">
                        <img src="{{ asset('logo/logo.png') }}" alt="Logo Brand" width="30px">
                        EcoVera
                    </a>
                </header>
