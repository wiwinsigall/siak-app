<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SIAK-APP</title>
    <link rel="stylesheet" href="{{ asset('assets/laravel-black/css/black-dashboard.css?v=1.0.0') }}">
    <link rel="stylesheet" href="{{ asset('assets/laravel-black/css/nucleo-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/laravel-black/css/custom.css') }}"> <!-- Memuat custom.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    @include('layouts.header') <!-- Header -->
    
    <div class="wrapper">
        @include('layouts.navbar') <!-- Navbar -->
        @auth
            @if(Auth::user()->role == 'staff')
                @include('layouts.sidebars.sidebar_staff')
            @elseif(Auth::user()->role == 'guru')
                @include('layouts.sidebars.sidebar_guru')
            @elseif(Auth::user()->role == 'kepsek')
                @include('layouts.sidebars.sidebar_kepsek')
            @elseif(Auth::user()->role == 'siswa')
                @include('layouts.sidebars.sidebar_siswa')
            @elseif(Auth::user()->role == 'wali_kelas')
                @include('layouts.sidebars.sidebar_wali_kelas')
            @endif
        @endauth
        
        <div class="main-content">
            @yield('content')  {{-- Tambahkan ini agar content dari child view bisa muncul --}}
        </div>
    </div>

    @include('layouts.footer') <!-- Footer -->
    @include('layouts.script') <!-- Script -->
</body>
</html>