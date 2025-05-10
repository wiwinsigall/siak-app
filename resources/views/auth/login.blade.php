<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>

    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/bootstrap-auth/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/bootstrap-auth/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }

        .header-box {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-box img {
            width: 50px;
            height: auto;
            margin-right: 15px;
        }

        .header-box h1 {
            font-size: 22px;
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
            font-size: 20px;
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
    </style>
</head>

<body class="bg-gradient-primary">
    <main class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg border-0 mx-auto col-lg-6 col-md-8 col-sm-10" style="max-width: 500px;">
            <div class="card-body p-4">
                <!-- Header dengan Logo dan Nama Sekolah -->
                <header class="header-box">
                    <img src="{{ asset('assets/bootstrap-auth/img/logo_smk.png') }}" alt="Logo Sekolah">
                    <div style="text-align: center;">
                        <h1>SMK NEGERI 1 MEMPURA</h1>
                        <p style="font-weight: bold; text-align: center;">Kabupaten Siak - Riau</p>
                    </div>
                </header>

                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                </div>

                @if(session('error'))
                    <p class="alert alert-danger">{{ session('error') }}</p>
                @endif
                @if(session('success'))
                    <p class="alert alert-success">{{ session('success') }}</p>
                @endif

                <form action="{{ route('login.action') }}" method="POST" class="user">
                    @csrf
                    <div class="form-group">
                        <input name="email" type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input name="password" type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="{{ route('register') }}">Create an Account!</a>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/bootstrap-auth/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap-auth/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/bootstrap-auth/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/bootstrap-auth/js/sb-admin-2.min.js') }}"></script>
</body>

</html>
