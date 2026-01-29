<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8" />
        <title>{{ config('app.name') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('logo') }}/logo.png">

        <!-- App css -->
        <link href="{{ asset('admin/dist') }}/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons -->
        <link href="{{ asset('admin/dist') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

        {{-- Sweetalert2 --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </head>
    <body data-menu-color="light" data-sidebar="default">
        @include('sweetalert2')
        <!-- Begin page -->
        <div id="app-layout">
