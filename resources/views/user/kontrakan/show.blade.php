@extends('user.layouts.app')

@section('title', 'Detail Kontrakan')

@section('content')
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-bg2.jpeg') }}');">
        <div class="container position-relative">
            <h1>{{ $kontrakan->nama }}</h1>
            <p>Detail informasi kontrakan yang tersedia.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">{{ $kontrakan->nama }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <section id="portfolio-details" class="portfolio-details section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                {{-- Gambar Slider --}}
                <div class="col-lg-8">
                    <div class="portfolio-details-slider swiper init-swiper">
                        <script type="application/json" class="swiper-config">
                        {
                            "loop": true,
                            "speed": 600,
                            "autoplay": { "delay": 5000 },
                            "slidesPerView": "auto",
                            "pagination": {
                                "el": ".swiper-pagination",
                                "type": "bullets",
                                "clickable": true
                            }
                        }
                    </script>

                        <div class="swiper-wrapper align-items-center">
                            @forelse ($kontrakan->foto_kontrakans as $foto)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/' . $foto->path) }}" alt="Foto Kontrakan"
                                        style="height: 400px; width: 100%; object-fit: cover; border-radius: 8px;">

                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <img src="{{ asset('front/assets/img/default/default1.jpeg') }}" alt="Default"
                                        style="height: 400px; width: 100%; object-fit: cover; border-radius: 8px;">

                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('front/assets/img/default/default2.jpeg') }}" alt="Default"
                                        style="height: 400px; width: 100%; object-fit: cover; border-radius: 8px;">

                                </div>
                                <div class="swiper-slide">
                                    <img src="{{ asset('front/assets/img/default/default3.jpeg') }}" alt="Default"
                                        style="height: 400px; width: 100%; object-fit: cover; border-radius: 8px;">

                                </div>
                            @endforelse
                        </div>

                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                {{-- Detail Kontrakan --}}
                <div class="col-lg-4">
                    <div class="portfolio-info" data-aos="fade-up" data-aos-delay="200">
                        <h3>Informasi Kontrakan</h3>
                        <ul>
                            <li><strong>Nama</strong>: {{ $kontrakan->nama }}</li>
                            <li><strong>Status</strong>:
                                {!! statusBadge($kontrakan->status) !!}
                            </li>
                            <li><strong>Harga</strong>: Rp {{ number_format($kontrakan->harga) }} / bulan</li>
                            <li><strong>Slug</strong>: {{ $kontrakan->slug }}</li>
                        </ul>
                    </div>
                    <div class="portfolio-description" data-aos="fade-up" data-aos-delay="300">
                        <h4>Deskripsi</h4>
                        <p>{!! nl2br(e($kontrakan->deskripsi)) !!}</p>
                    </div>

                    {{-- Tombol Sewa --}}
                    @if ($kontrakan->status == 'tersedia')
                        <a href="{{ route('user.sewa.create', $kontrakan->id) }}"
                            class="btn btn-primary btn-block mt-3 w-100">
                            <i class="bi bi-cart-check"></i> Sewa Sekarang
                        </a>
                    @else
                        <div class="alert alert-warning mt-3">
                            Kontrakan ini sedang disewa.
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </section>
@endsection
