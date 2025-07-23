<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <link href="{{ asset('front/assets/img/logo.png') }}" rel="icon">
    <link href="{{ asset('front/assets/img/logo.png') }}" rel="apple-touch-icon">

    <link href="{{ asset('front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/style.css') }}" rel="stylesheet">

    <style>
        .hero-overlay {
            position: relative;
            background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .hero-overlay::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }
    </style>
</head>

<body>
    <div class="hero-overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div
                    class="hero-content col-12 col-md-8 col-lg-6 text-center bg-white bg-opacity-75 rounded p-4 p-md-5 shadow">

                    <h2 class="mb-3 fs-3">Verifikasi Email Anda</h2>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success small">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </div>
                    @endif

                    <p class="mb-2 small">Terima kasih telah mendaftar. Silakan cek email Anda untuk link verifikasi.
                    </p>
                    <p class="mb-3 small">Jika belum menerima email, Anda bisa mengirim ulang di bawah ini.</p>

                    <form method="POST" action="{{ route('verification.send') }}" class="d-grid gap-2 mb-3">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Kirim Ulang Link Verifikasi</button>
                    </form>

                    <form action="{{ route('user.logout') }}" method="POST">
                        @csrf
                        <button class="btn btn-link text-danger btn-sm">Keluar</button>
                    </form>

                    <p class="text-muted small mt-4">Belum menerima email? Pastikan cek folder spam juga.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
