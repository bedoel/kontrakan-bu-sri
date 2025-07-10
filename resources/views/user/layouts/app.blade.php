<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title', 'Kontrakan Bu Sri')</title>
    <meta name="description" content="Website manajemen kontrakan Bu Sri">
    <meta name="keywords" content="kontrakan, sewa, rumah, jakarta timur">

    <!-- Favicons -->
    <link href="{{ asset('front/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('front/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS -->
    <link href="{{ asset('front/assets/css/main.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="index-page">

    <!-- Header -->
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center">

            <a href="{{ route('user.home') }}" class="logo me-auto">
                <h1 class="sitename">Kontrakan Bu Sri</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li>
                        <a href="{{ route('user.home') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
                    </li>
                    <li><a href="{{ route('user.kontrakan.index') }}"
                            class="{{ request()->is('kontrakan*') ? 'active' : '' }}">Kontrakan</a></li>

                    @if (auth('user')->check())
                        <li><a href="{{ route('user.sewa.index') }}"
                                class="{{ request()->is('sewa*') ? 'active' : '' }}">Daftar Sewa</a></li>
                        <li><a href="{{ route('user.transaksi.index') }}"
                                class="{{ request()->is('transaksi*') ? 'active' : '' }}">Riwayat Transaksi</a></li>

                        @if ($punyaSewaAktif)
                            <li><a href="{{ route('user.pengaduan.index') }}"
                                    class="{{ request()->is('pengaduan*') ? 'active' : '' }}">Pengaduan</a></li>
                        @endif
                    @endif

                    <li>
                        <a href="{{ route('user.home') }}#about"
                            class="{{ request()->is('/') ? 'active' : '' }}">Tentang Kami</a>
                    </li>
                    @if (auth('user')->check())
                        {{-- Dropdown User --}}
                        <li class="dropdown">
                            <a href="#">
                                <img src="{{ auth('user')->user()->poto_profil ? asset('storage/' . auth('user')->user()->poto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode(auth('user')->user()->name) }}"
                                    class="rounded-circle me-1" width="30" height="30"
                                    style="object-fit: cover;">
                                <span>{{ auth('user')->user()->name }}</span>
                                <i class="bi bi-chevron-down toggle-dropdown"></i>
                            </a>
                            <ul>
                                <li><a href="{{ route('user.profile.edit') }}">Profil</a></li>
                                <li><a href="{{ route('user.testimoni.index') }}">Ulasan Saya</a></li>
                                <li>
                                    <a href="#"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                            </ul>

                        </li>
                    @endif
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            @guest('user')
                <a href="{{ route('user.register') }}" class="cta-btn">Register</a>
            @endguest
        </div>
    </header>


    <!-- Main Content -->
    <main class="main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer" class="footer dark-background">
        <div class="container footer-top">
            <div class="row gy-4">

                <!-- Tentang -->
                <div class="col-6 col-md-6 footer-about">
                    <a href="{{ route('user.home') }}" class="logo d-flex align-items-center">
                        <span class="sitename">Kontrakan Bu Sri</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jl. Buaran 1, RT 04 / RW 08 No.36</p>
                        <p>Cakung, Jatinegara, Jakarta Timur</p>
                        <p class="mt-3">
                            <strong>Telp:</strong> <span>+62 812 3456 7890</span>
                        </p>
                        <p>
                            <strong>Email:</strong> <span>kontak@kontrakanbusri.com</span>
                        </p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="#"><i class="bi bi-whatsapp"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <!-- Navigasi -->
                <div class="col-6 col-md-6 footer-links">
                    <h4>Menu Utama</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="{{ route('user.home') }}">Beranda</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="{{ route('user.kontrakan.index') }}">Daftar
                                Kontrakan</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="{{ route('testimoni.index') }}">Testimoni</a>
                        </li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>
                &copy; {{ now()->year }}
                <strong class="px-1 sitename">Kontrakan Bu Sri</strong> - Semua Hak Dilindungi
            </p>
            <div class="credits">
                Dibuat dengan ❤️ oleh <a href="https://github.com/BeDOEL" target="_blank">Fadlur Rahman Fa'iq</a>
            </div>
        </div>
    </footer>


    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    {{-- jQuery (required by DataTables) --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    {{-- DataTables JS --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @php
        $swal = session()->pull('swal'); // mengambil dan menghapus langsung
    @endphp

    @if ($swal)
        <script>
            Swal.fire({
                icon: '{{ $swal['icon'] ?? 'info' }}',
                title: '{{ $swal['title'] ?? '' }}',
                text: '{{ $swal['text'] ?? '' }}',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ $swal['redirect'] ?? url('/') }}";
                }
            });
        </script>
    @endif




    <!-- Scripts -->
    <script src="{{ asset('front/assets') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front/assets') }}/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('front/assets') }}/vendor/aos/aos.js"></script>
    <script src="{{ asset('front/assets') }}/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="{{ asset('front/assets') }}/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="{{ asset('front/assets') }}/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('front/assets') }}/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{ asset('front/assets') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
