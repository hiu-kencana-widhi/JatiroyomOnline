<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Surat Desa Jatiroyom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('image/logo-jatiroyomonline.png') }}">
    <link rel="preload" href="{{ asset('image/logo-jatiroyomonline.png') }}" as="image">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            color: #0f172a;
        }
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 45px 40px;
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }
        .login-card:hover {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.12);
        }
        .form-control {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            color: #0f172a;
            border-radius: 12px;
            padding: 14px;
            font-size: 0.95rem;
            transition: all 0.25s ease;
        }
        .form-control:focus {
            background: #ffffff;
            border-color: #2563eb;
            color: #0f172a;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }
        .form-control::placeholder {
            color: #94a3b8;
        }
        .btn-primary {
            background: #2563eb;
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 8px 16px -4px rgba(37, 99, 235, 0.25);
        }
        .btn-primary:hover {
            background: #1d4ed8;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -4px rgba(37, 99, 235, 0.35);
        }
        .error-msg {
            color: #ef4444;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 6px;
        }
        .hover-primary:hover {
            color: #2563eb !important;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="text-center mb-4 pb-2">
            <img src="{{ asset('image/logo-jatiroyomonline.png') }}" alt="Logo Jatiroyom Online" style="height: 75px; width: auto; object-fit: contain; filter: drop-shadow(0 4px 6px rgba(37, 99, 235, 0.15));">
            <h3 class="fw-bold text-dark mt-3 mb-0 tracking-tight">Jatiroyom<span style="color: #2563eb;">Online</span></h3>
        </div>
        @yield('content')
    </div>
    @include('components.app-sound')
</body>
</html>
