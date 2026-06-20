<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login | Monitoring Santri Al-Misykah</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --warna-hijau: #1a531b;
            --warna-emas: #d4a017;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--warna-hijau) 0%, #2e7d32 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 15px;
        }

        /* UKURAN KARTU DIPERKECIL DI SINI */
        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 350px; /* Diperkecil dari 420px */
            padding: 25px 20px; /* Padding dikurangi agar lebih compact */
            border-top: 8px solid var(--warna-emas);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-section img {
            width: 65px; /* Logo diperkecil dari 90px */
            height: auto;
            margin-bottom: 10px;
        }

        .brand-name {
            color: var(--warna-hijau);
            font-weight: 800;
            font-size: 1.05rem; /* Ukuran teks diperkecil */
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }

        .sub-brand {
            color: var(--warna-emas);
            font-weight: 700;
            font-size: 0.7rem; /* Ukuran teks diperkecil */
            text-transform: uppercase;
        }

        .form-label {
            font-weight: 700;
            font-size: 0.7rem;
            color: #666;
            margin-bottom: 5px;
        }

        /* INPUT FIELD DIBUAT LEBIH RINGKAS */
        .input-group {
            background-color: #f9f9f9;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
            color: var(--warna-hijau);
            padding-left: 12px;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            padding: 10px 10px; /* Padding input dikurangi */
            font-size: 14px; /* Ukuran font input standar */
            border: none;
            background: transparent;
        }

        .form-control:focus, .form-select:focus {
            box-shadow: none;
            background: transparent;
        }

        /* TOMBOL DIBUAT LEBIH KECIL */
        .btn-login {
            background-color: var(--warna-hijau);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            font-size: 0.9rem;
            color: #ffffff;
            width: 100%;
            margin-top: 5px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #0e350f;
            transform: translateY(-1px);
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            font-size: 0.65rem;
            color: #aaa;
        }

        /* Alert diperkecil */
        .alert-error {
            background-color: #fff5f5;
            color: #c53030;
            border: 1px solid #feb2b2;
            border-radius: 8px;
            padding: 8px 12px;
            font-size: 0.75rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo-section">
        <img src="{{ asset('img/pp.png') }}">
        <div class="brand-name">MONITORING SANTRI</div>
        <div class="sub-brand">PP AL-MISYKAH</div>
    </div>

    @if(session()->has('loginError'))
    <div class="alert-error">
        <i class="fas fa-exclamation-circle me-1"></i> {{ session('loginError') }}
    </div>
    @endif

    <form action="/login" method="POST">
        @csrf
        
        <div class="mb-2">
            <label class="form-label">Masuk Sebagai</label>
            <div class="input-group shadow-sm">
                <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
                <select name="role" class="form-select" required>
                    <option value="wali">Wali Santri</option>
                    <option value="admin">Pengurus / Admin</option>
                </select>
            </div>
        </div>

        <div class="mb-2">
            <label class="form-label">Nama Lengkap Anak</label>
            <div class="input-group shadow-sm">
                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Huruf Kapital !" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group shadow-sm">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit" class="btn btn-login shadow-sm">
            MASUK <i class="fas fa-arrow-right ms-1"></i>
        </button>
    </form>

    <div class="footer-text">
        &copy; {{ date('Y') }} Pondok Pesantren Al-Misykah <br>
        IT Support & System Development
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>