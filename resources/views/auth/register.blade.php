<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <link rel="icon" href="{{ asset('template/dist') }}/assets/images/favicon.svg" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/tabler-icons.min.css">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/feather.css">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/fontawesome.css">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/fonts/material.css">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/css/style.css">
  <link rel="stylesheet" href="{{ asset('template/dist') }}/assets/css/style-preset.css">
</head>
<body>

<div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center bg-light">
  <div class="card shadow w-100" style="max-width: 500px;">
    <div class="card-body p-4">
      
      <!-- Logo -->
      <div class="bg-white rounded-4 shadow-sm p-3 mb-4 text-center">
        <div class="d-flex align-items-center justify-content-center gap-3">
          <img src="{{ asset('template/dist') }}/assets/images/logo_smk.png" alt="logo" height="50">
          <div class="text-start">
            <h3 class="fw-bold mb-0">SMK NEGERI 1 MEMPURA</h3>
            <p class="mb-0">Kabupaten Siak - Riau</p>
          </div>
        </div>
      </div>

      <!-- Title -->
      <div class="text-center mb-4">
        <h3><b>Sign Up</b></h3>
      </div>

      <!-- Form -->
      <form method="POST" action="{{ route('registerAction') }}">
        @csrf

        <div class="form-group mb-3">
          <label class="form-label">Nama Lengkap*</label>
          <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
          @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
          @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
          @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Ulangi Password</label>
          <input type="password" name="password_confirmation" class="form-control" required>
          @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group mb-3">
          <label class="form-label">Pilih Role</label>
          <select name="role" id="role" class="form-control" required>
            <option value="" disabled selected>Pilih Role</option>
            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
            <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
            <option value="kepsek" {{ old('role') == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah</option>
            <option value="wali_kelas" {{ old('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
          </select>
          @error('role') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- NIP Field -->
        <div class="form-group mb-3" id="nip-field" style="display: none;">
          <label class="form-label">NIP</label>
          <input name="nip" type="text" value="{{ old('nip') }}" class="form-control">
          @error('nip') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- NIS Field -->
        <div class="form-group mb-3" id="nis-field" style="display: none;">
          <label class="form-label">NIS</label>
          <input name="nis" type="text" value="{{ old('nis') }}" class="form-control">
          @error('nis') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-grid mt-3">
          <button type="submit" class="btn btn-primary">Create Account</button>
        </div>

        <div class="text-center mt-2">
          <a href="{{ route('login') }}" class="link-primary">Already have an account?</a>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- [ Scripts ] -->
<script src="{{ asset('template/dist') }}/assets/js/plugins/bootstrap.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const nipField = document.getElementById('nip-field');
    const nisField = document.getElementById('nis-field');

    function toggleInputFields() {
      const role = roleSelect.value;

      if (['guru', 'kepsek', 'wali_kelas'].includes(role)) {
        nipField.style.display = 'block';
        nisField.style.display = 'none';
      } else if (role === 'siswa') {
        nipField.style.display = 'none';
        nisField.style.display = 'block';
      } else {
        nipField.style.display = 'none';
        nisField.style.display = 'none';
      }
    }

    roleSelect.addEventListener('change', toggleInputFields);
    toggleInputFields(); // Call once on page load
  });
</script>
</body>
</html>
