<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/laravel-black/img/apple-icon.png') }}">
        <link rel="icon" type="image/png" href="{{ asset('assets/laravel-black/img/favicon.png') }}">

        <title>SIAK-APP</title>

        <!-- Fonts and Icons -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet"/>
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

        <!-- Nucleo Icons -->
        <link href="{{ asset('assets/laravel-black/css/nucleo-icons.css') }}" rel="stylesheet"/>

        <!-- CSS Files -->
        <link href="{{ asset('assets/laravel-black/css/black-dashboard.css?v=1.0.0') }}" rel="stylesheet"/>
        
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link href="{{ asset('assets/laravel-black/demo/demo.css') }}" rel="stylesheet"/>

        <!-- Custom CSS-->
        <link rel="stylesheet" href="{{ asset('assets/laravel-black/css/custom.css') }}">
    </head>
</html>
