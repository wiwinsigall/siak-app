<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent" 
    style="z-index: 1040; position: fixed; top: 0; left: 0; width: 100%; height: 60px; background-color: #1a1d2d;">
  <div class="container-fluid">

    <!-- Tombol Toggle untuk Navbar Responsif -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" 
        aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
      <span class="navbar-toggler-bar navbar-kebab"></span>
    </button>

    <div class="collapse navbar-collapse" id="navigation">
      <ul class="navbar-nav ml-auto">
        <!-- Profil Pengguna (Hanya Ikon) -->
        <li class="dropdown nav-item">
          <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
            <i class="fas fa-user-circle" style="font-size: 20px; color: #ffffff;"></i> 
          </a>
          <ul class="dropdown-menu dropdown-navbar">
            <li class="nav-link">
              <a href="javascript:void(0)" class="nav-item dropdown-item">Profile</a>
            </li>
            <li class="dropdown-divider"></li>
            <li class="nav-link">
              <a href="logout.php" class="nav-item dropdown-item">Log out</a>
            </li>
          </ul>
        </li>
        <li class="separator d-lg-none"></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Tambahkan FontAwesome untuk ikon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
