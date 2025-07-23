<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <!-- Favicon & Bootstrap -->
    <link href="{{ asset('front/assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('front/assets/img/logo.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/style.css') }}" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .hero-overlay {
            position: relative;
            background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .hero-overlay::before {
            content: "";
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .auth-box {
            z-index: 2;
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: .75rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 480px;
        }

        .auth-logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .auth-logo img {
            height: 60px;
            object-fit: contain;
        }

        @media (max-width: 576px) {
            .auth-box {
                padding: 1.5rem;
            }

            .auth-logo img {
                height: 48px;
            }

            h3 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <div class="hero-overlay">
        <div class="auth-box">
            <div class="auth-logo">
                <img src="{{ asset('front/assets/img/logo.png') }}" alt="Logo Kontrakan Bu Sri">
            </div>
            <h3 class="text-center mb-4">Login Admin</h3>

            <form method="POST" action="{{ url('/admin/login') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" class="form-control" required>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn w-100 text-white" style="background-color: #6c63ff;">Masuk</button>

                <div class="mt-3 text-center">
                    <a href="{{ url('/') }}" class="text-decoration-none">← Kembali ke Beranda</a>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
