<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>

  <!-- Meta -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="Mantis is made using Bootstrap 5 design framework." />
  <meta name="keywords" content="Mantis, Bootstrap 5, Admin Template, Dashboard" />
  <meta name="author" content="CodedThemes" />

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('template/dist') }}/assets/images/favicon.svg" type="image/x-icon" />

  <!-- Fonts & Icons -->
  <link
    rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
    id="main-font-link"
  />
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/tabler-icons.min.css" />
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/feather.css" />
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/fontawesome.css" />
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/material.css" />

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/css/style.css" id="main-style-link" />
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/css/style-preset.css" />

  <!-- Vite (Laravel asset bundling) -->
  @vite(['resources/js/app.js'])
</head>

<body>
  <!-- Pre-loader -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>

  <!-- Login Layout -->
  <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card shadow w-100" style="max-width: 500px;">
      <div class="card-body p-4">
        <!-- Logo Card -->
        <div class="bg-white rounded-4 shadow-sm p-3 mb-4 text-center">
          <div class="d-flex align-items-center justify-content-center gap-3">
            <img src="{{ asset('template/dist') }}/assets/images/logo_smk.png" alt="logo" height="50" />
            <div class="text-start">
              <h3 class="fw-bold mb-0">SMK NEGERI 1 MEMPURA</h3>
              <p class="mb-0 text-center">Kabupaten Siak - Riau</p>
            </div>
          </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-4">
          <h3 class="mb-0"><b>Welcome Back</b></h3>
        </div>

        <!-- Form Start -->
        <form action="{{ route('loginAction') }}" method="POST" class="user">
          @csrf
          <div class="form-group mb-3">
            <label class="form-label">Email Address</label>
            <input
              type="email"
              name="email"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="Email Address"
            />
            @error('email')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Password</label>
            <input
              type="password"
              name="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="Password"
            />
            @error('password')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-primary btn-user btn-block mb-2">Login</button>
          </div>

          @if(isset($showRegister) && $showRegister)
            <div class="text-center">
              <a href="{{ route('register') }}" class="link-primary">Don't have an account?</a>
            </div>
          @endif
        </form>
        <!-- Form End -->
      </div>
    </div>
  </div>

  <!-- Required JS -->
  <script src="{{ asset('template/dist') }}/assets/js/plugins/popper.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/simplebar.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/bootstrap.min.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/fonts/custom-font.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/pcoded.js"></script>
  <script src="{{ asset('template/dist') }}/assets/js/plugins/feather.min.js"></script>

  <!-- Custom JS Config -->
  <script>
    layout_change('light');
    change_box_container('false');
    layout_rtl_change('false');
    preset_change('preset-1');
    font_change('Public-Sans');
  </script>
</body>

</html>
