@extends('user.layouts.app')

@section('title', 'Daftar Kontrakan')

@section('content')

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Daftar Kontrakan</h1>
            <p>Temukan kontrakan terbaik dan sesuai kebutuhan Anda.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Beranda</a></li>
                    <li class="current">Kontrakan</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Kontrakan Section -->
    <section id="portfolio" class="portfolio section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Kontrakan Tersedia</h2>
            <p>Cek daftar kontrakan yang dapat Anda sewa</p>
        </div>

        <div class="container">
            <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

                {{-- Opsional: Filter Kategori --}}
                <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                    <li data-filter="*" class="filter-active">Semua</li>
                    <li data-filter=".filter-tersedia">Tersedia</li>
                    <li data-filter=".filter-disewa">Disewa</li>
                </ul>

                <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                    @foreach ($kontrakans as $kontrakan)
                        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ $kontrakan->status }}">
                            <div class="border rounded shadow-sm bg-white">
                                <div class="portfolio-content overflow-hidden">

                                    {{-- Gambar --}}
                                    <img src="{{ $kontrakan->foto_kontrakans->first()
                                        ? asset('storage/' . $kontrakan->foto_kontrakans->first()->path)
                                        : 'https://picsum.photos/600/400?random=' . $loop->iteration }}"
                                        class="img-fluid w-100" style="height: 250px; object-fit: cover;"
                                        alt="{{ $kontrakan->nama }}">

                                    {{-- Tombol Zoom & Detail --}}
                                    <div class="portfolio-info">
                                        <a href="{{ $kontrakan->foto_kontrakans->first() ? asset('storage/' . $kontrakan->foto_kontrakans->first()->path) : '#' }}"
                                            title="{{ $kontrakan->nama }}" data-gallery="portfolio-gallery"
                                            class="glightbox preview-link">
                                            <i class="bi bi-zoom-in"></i>
                                        </a>

                                        <a href="{{ route('user.kontrakan.show', $kontrakan->id) }}" title="Lihat Detail"
                                            class="details-link">
                                            <i class="bi bi-link-45deg"></i>
                                        </a>
                                    </div>
                                </div>


                                {{-- Informasi Nama & Harga --}}
                                <div class="px-3 pt-3 pb-3">
                                    <h5 class="fw-bold mb-1 text-dark">{{ $kontrakan->nama }}</h5>
                                    <p class="text-success fw-semibold mb-0">
                                        Rp {{ number_format($kontrakan->harga) }} / bulan
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $kontrakans->links('pagination::bootstrap-5') }}
                </div>


                <!-- End Portfolio Container -->

            </div>
        </div>
    </section>

@endsection
