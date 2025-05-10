<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1a, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register</title>

    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Custom styles for this template -->
    <link href="../assets/bootstrap-auth/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../assets/bootstrap-auth/css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .header-box {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fc;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header-box img {
            width: 40px;
            height: auto;
            margin-right: 10px;
        }
        .header-box h1 {
            font-size: 20px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            color: #333;
        }
        .header-box p {
            font-size: 14px;
            font-weight: 400;
            margin: 0;
            color: #666;
        }
        .text-center h1 {
            font-size: 16px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
            color: #333;
        }
        .form-control {
            font-size: 16px;
            padding: 10px;
            border-radius: 8px;
        }
        .btn-user {
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
            border-radius: 8px;
            padding: 10px;
        }
        .text-danger {
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body class="bg-gradient-primary">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg border-0 mx-auto col-lg-6 col-md-8 col-sm-10" style="max-width: 500px;">
            <div class="card-body p-4">
                <!-- Header dengan Logo dan Nama Sekolah -->
                <div class="header-box">
                    <img src="../assets/bootstrap-auth/img/logo_smk.png" alt="Logo Sekolah">
                    <div style="text-align: center;">
                        <h1>SMK NEGERI 1 MEMPURA</h1>
                        <p style="font-weight: bold; text-align: center;">Kabupaten Siak - Riau</p>
                    </div>
                </div>

                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                </div>

                @if(session('success'))
                <p class="alert alert-success">{{(session('success'))}}</p>
                @endif
                @if($errors->any())
                @foreach($errors->all() as $err)
                <p class="alert alert-danger">{{ $err }}</p>
                @endforeach
                @endif
                
                <form action="{{ route('register.action') }}" method="POST" class="user">
                    @csrf
                    <div class="form-group">
                        <input name="nama" type="text" value="{{ old('nama') }}" class="form-control form-control-user @error('nama') is-invalid @enderror" id="exampleInputName" placeholder="Nama Lengkap">
                        @error('nama')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <input name="email" type="email" value="{{ old('email') }}" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" placeholder="Email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <input name="password" type="password" autocomplete="off" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input name="password_confirmation" type="password" autocomplete="off" class="form-control form-control-user" id="exampleRepeatPassword" placeholder="Ulangi Password">
                    </div>

                    <div class="form-group">
                        <select name="role" id="role" class="form-control form-control-user @error('role') is-invalid @enderror" required>
                            <option value="" disabled selected hidden>Pilih Role</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="guru" {{ old('role') == 'guru' ? 'selected' : '' }}>Guru</option>
                            <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="kepsek" {{ old('role') == 'kepsek' ? 'selected' : '' }}>Kepala Sekolah</option>
                            <option value="wali_kelas" {{ old('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
                        </select>
                        @error('role')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>



                    <button type="submit" class="btn btn-primary btn-user btn-block">Register</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="../assets/bootstrap-auth/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/bootstrap-auth/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript -->
    <script src="../assets/bootstrap-auth/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages -->
    <script src="../assets/bootstrap-auth/js/sb-admin-2.min.js"></script>

</body>
</html>
