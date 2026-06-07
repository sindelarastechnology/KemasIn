<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">
    <title>Login - SI Kemasan UMKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 400px;
            max-width: 90vw;
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
        }
        .login-card .card-body {
            padding: 40px;
        }
        .password-toggle {
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0 14px;
            color: #6c757d;
            z-index: 10;
        }
        .password-toggle:hover { color: #0d6efd; }
        .password-toggle:focus { outline: none; }
        .form-control, .input-group-text {
            border-radius: 10px;
        }
        .input-group .form-control:not(:first-child) {
            border-radius: 0 10px 10px 0;
        }
        .input-group .input-group-text:first-child {
            border-radius: 10px 0 0 10px;
        }
        .btn-login {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="login-card card shadow">
        <div class="card-body">
            <div class="text-center mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="60" class="mb-3">
                <h4 class="fw-bold">SI Kemasan UMKM</h4>
                <p class="text-muted small">Sistem Informasi Manajemen Produksi & Pengemasan</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger py-2">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ $errors->first('username') ?: 'Login gagal' }}
                    </div>
                @endif

                <div class="mb-3">
                    <label for="username" class="form-label fw-medium small">Username</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
                        <input type="text" class="form-control bg-light" id="username" name="username" value="{{ old('username') }}" required autofocus placeholder="Masukkan username">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-medium small">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" class="form-control bg-light" id="password" name="password" required placeholder="Masukkan password">
                        <button type="button" class="password-toggle input-group-text bg-light" onclick="togglePassword()" tabindex="-1">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 btn-login shadow-sm">
                    <i class="fas fa-sign-in-alt me-1"></i> Login
                </button>
            </form>
        </div>
    </div>

    <script>
    function togglePassword() {
        var input = document.getElementById('password');
        var icon = document.getElementById('toggleIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    </script>
</body>
</html>
