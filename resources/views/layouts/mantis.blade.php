<!DOCTYPE html>
<html lang="en">

<head>
  <title>SIAK APP</title>

  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework.">
  <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5">
  <meta name="author" content="CodedThemes">

  <link rel="icon" href="{{ asset('template/dist') }}/assets/images/favicon.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/feather.css">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/material.css">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/css/style.css" id="main-style-link">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/css/style-preset.css">
  <link href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css" rel="stylesheet">
  @vite(['resources/js/app.js'])

  <style>
    .custom-pagination .dataTables_paginate {
      margin-right: 10px;
    }

    /* Tambahan agar sidebar & header ikut collapse */
    body.pc-sidebar-collapsed .pc-sidebar {
      margin-left: -240px;
      transition: all 0.3s ease;
    }

    body.pc-sidebar-collapsed .pc-container {
      margin-left: 0 !important;
      transition: all 0.3s ease;
    }

    body.pc-sidebar-collapsed .pc-header {
      left: 0 !important;
      width: 100% !important;
      transition: all 0.3s ease;
    }

    .pc-sidebar,
    .pc-container,
    .pc-header {
      transition: all 0.3s ease;
    }
  </style>
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] end -->

  <!-- [ Sidebar Menu ] start -->
  @php $role = Auth::user()->role; @endphp
  @if($role == 'guru')
    <x-sidebar.guru />
  @elseif($role == 'siswa')
    <x-sidebar.siswa />
  @elseif($role == 'kepsek')
    <x-sidebar.kepsek />
  @elseif($role == 'wali_kelas')
    <x-sidebar.wali_kelas />
  @elseif($role == 'staff')
    <x-sidebar.staff />
  @endif
  <!-- [ Sidebar Menu ] end -->

  <!-- [ Header Topbar ] start -->
  <x-header></x-header>
  <!-- [ Header ] end -->

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <x-breadcrumbs></x-breadcrumbs>

      <div class="row">
        @if(session('success'))
          <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
          </div>
        @endif
        @yield('content')
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->

  <x-footer></x-footer>

  <!-- JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#table').DataTable({
        language: {
          search: "Search",
          searchPlaceholder: ""
        },
      });

      $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
        $(this).slideUp(500);
      });

      $("#error-alert").fadeTo(2000, 500).slideUp(500, function () {
        $(this).slideUp(500);
      });
    });

    // Sidebar collapse behavior
    document.addEventListener("DOMContentLoaded", function () {
      const sidebarToggle = document.getElementById("sidebar-hide");
      const body = document.body;

      sidebarToggle?.addEventListener("click", function (e) {
        e.preventDefault();
        body.classList.toggle("pc-sidebar-collapsed");
      });
    });
  </script>

  <script src="{{ asset('template/dist') }}/assets/js/plugins/apexcharts.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/pages/dashboard-default.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/popper.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/simplebar.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/bootstrap.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/fonts/custom-font.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/pcoded.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/feather.min.js"></script>

  <script>layout_change('light');</script>
  <script>change_box_container('false');</script>
  <script>layout_rtl_change('false');</script>
  <script>preset_change("preset-1");</script>
  <script>font_change("Public-Sans");</script>
</body>
</html>
