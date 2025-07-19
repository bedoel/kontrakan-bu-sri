@extends('user.layouts.app')

@section('title', 'Beranda')

@section('content')
    <!-- Hero Carousel -->
    <section id="hero" class="hero section dark-background">

        <img src="{{ asset('front/assets/img/hero-bg3.jpeg') }}" alt="" data-aos="fade-in">

        <div class="container d-flex flex-column align-items-center">
            <h2 data-aos="fade-up" data-aos-delay="100">Temukan Hunian Nyaman Anda</h2>
            <p data-aos="fade-up" data-aos-delay="200">
                Kelola sewa kontrakan dengan mudah, cepat, dan transparan langsung dari genggaman Anda.
            </p>
            <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                <a href="{{ route('user.kontrakan.index') }}" class="btn-get-started">Lihat Kontrakan</a>
            </div>
        </div>


    </section>

    <!-- Section Kontrakan Terbaru -->
    <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Kontrakan Tersedia</h2>
            <p>Berikut beberapa kontrakan yang bisa Anda sewa</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-5">

                @foreach ($kontrakans as $index => $kontrakan)
                    <div class="col-xl-4 col-md-6" data-aos="zoom-in" data-aos-delay="{{ 200 + $index * 100 }}">
                        <div class="service-item">
                            <!-- Gambar -->
                            <div class="img">
                                @if ($kontrakan->foto_kontrakans->first())
                                    <img src="{{ asset('storage/' . $kontrakan->foto_kontrakans->first()->path) }}"
                                        class="img-fluid w-100" alt="{{ $kontrakan->nama }}">
                                @else
                                    <img src="{{ asset('front/assets/img/default/default1.jpeg') }}" class="img-fluid w-100"
                                        alt="Foto Kontrakan" style="height: 250px; object-fit: cover;">
                                @endif
                            </div>

                            <!-- Detail -->
                            <div class="details position-relative">
                                <div class="icon">
                                    <i class="bi bi-house-door"></i>
                                </div>
                                <a href="{{ route('user.kontrakan.show', $kontrakan->slug) }}" class="stretched-link">
                                    <h3>{{ $kontrakan->nama }}</h3>
                                </a>
                                <p>
                                    {{ Str::limit($kontrakan->deskripsi, 80) }}<br>
                                    <strong>Rp {{ number_format($kontrakan->harga) }}/bulan</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Tombol Lihat Lebih Banyak -->
            <div class="text-center mt-5">
                <a href="{{ route('user.kontrakan.index') }}" class="btn-get-started">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Lihat Lebih Banyak Kontrakan
                </a>
            </div>

        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="stats section light-background">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row gy-4">

                <!-- Jumlah Penghuni -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item d-flex align-items-center w-100 h-100">
                        <i class="bi bi-emoji-smile color-blue flex-shrink-0"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahPenghuni }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Penghuni Puas</p>
                        </div>
                    </div>
                </div>

                <!-- Unit Kontrakan -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item d-flex align-items-center w-100 h-100">
                        <i class="bi bi-house-door color-orange flex-shrink-0"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahUnit }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Total Unit Kontrakan</p>
                        </div>
                    </div>
                </div>

                <!-- Total Sewa -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item d-flex align-items-center w-100 h-100">
                        <i class="bi bi-file-earmark-check color-green flex-shrink-0"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $totalSewa }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Total Sewa Berjalan</p>
                        </div>
                    </div>
                </div>

                <!-- Ulasan -->
                <div class="col-lg-3 col-md-6">
                    <div class="stats-item d-flex align-items-center w-100 h-100">
                        <i class="bi bi-chat-left-quote color-pink flex-shrink-0"></i>
                        <div>
                            <span data-purecounter-start="0" data-purecounter-end="{{ $jumlahUlasan }}"
                                data-purecounter-duration="1" class="purecounter"></span>
                            <p>Ulasan Penghuni</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- /Stats Section -->




    <!-- About Section -->
    <section id="about" class="about section">
        <div class="container">
            <div class="row gy-4">
                <!-- Kolom Deskripsi dan Gambar -->
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <h3>Kenapa Memilih Kontrakan Bu Sri?</h3>
                    <img src="{{ asset('front/assets/img/about3.jpeg') }}" class="img-fluid rounded-4 mb-4"
                        alt="Tentang Kontrakan Bu Sri" />
                    <p>
                        Kontrakan Bu Sri adalah hunian yang nyaman dan terjangkau di kawasan <strong>Cakung, Jakarta
                            Timur</strong>.
                        Dengan 21 unit kamar yang bersih dan aman, kami siap menjadi pilihan tempat tinggal Anda yang
                        praktis dan terpercaya.
                    </p>
                    <p>
                        Lokasi strategis, proses penyewaan mudah secara online, serta sistem pemantauan masa sewa dan
                        pembayaran yang transparan adalah keunggulan kami.
                        Kami hadir untuk memenuhi kebutuhan hunian jangka panjang maupun sementara, baik untuk keluarga
                        maupun pekerja.
                    </p>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="250">
                    <div class="content ps-0 ps-lg-5">
                        <p class="fst-italic">
                            Lokasi strategis yang mudah diakses dan aman untuk tempat tinggal Anda.
                        </p>

                        <h5 class="mb-2"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Alamat Lengkap</h5>
                        <p>
                            Jl. Buaran 1, RT 04 / RW 08 No.36
                            Cakung, Jatinegara, Jakarta Timur
                        </p>

                        <div class="ratio ratio-16x9 rounded-4 shadow-sm overflow-hidden">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d495.79642683942365!2d106.91875423610685!3d-6.2146511!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698ca9e6898e41%3A0x55dc3ee92a3fbf6c!2sJl.%20Waru%20Doyong%2C%20RT.4%2FRW.8%2C%20Jatinegara%2C%20Kec.%20Cakung%2C%20Kota%20Jakarta%20Timur%2C%20Daerah%20Khusus%20Ibukota%20Jakarta%2013930!5e0!3m2!1sen!2sid!4v1752844471481!5m2!1sen!2sid"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <p class="mt-3">
                            Silakan datang langsung atau hubungi kami terlebih dahulu untuk informasi lebih lanjut dan
                            ketersediaan unit.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- /About Section -->


    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section dark-background">
        <img src="{{ asset('front/assets/img/footer.png') }}" class="testimonials-bg" alt="">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper init-swiper">
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

                <div class="swiper-wrapper">
                    @forelse($ulasans as $t)
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{ $t->user->poto_profil
                                    ? asset('storage/' . $t->user->poto_profil)
                                    : 'https://ui-avatars.com/api/?name=' . urlencode($t->user->name) }}"
                                    class="testimonial-img" alt="{{ $t->user->name }}">

                                <h3>{{ $t->user->name }}</h3>
                                <div class="stars">
                                    @for ($i = 1; $i <= $t->rating; $i++)
                                        <i class="bi bi-star-fill"></i>
                                    @endfor
                                </div>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>{{ $t->pesan }}</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <h3>Belum ada Ulasan</h3>
                                <p>
                                    <i class="bi bi-quote quote-icon-left"></i>
                                    <span>Penghuni belum memberikan ulasan.</span>
                                    <i class="bi bi-quote quote-icon-right"></i>
                                </p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="swiper-pagination"></div>
            </div>

            <!-- Tombol Lihat Semua Ulasan -->
            <div class="text-center mt-4">
                <a href="{{ route('ulasan.index') }}" class="btn btn-outline-light">
                    <i class="bi bi-chat-left-text"></i> Lihat Lebih Banyak Ulasan
                </a>
            </div>
        </div>
    </section>




    @if (auth('user')->check() && !$userHasUlasan)
        <!-- Form Ulasan -->
        <section class="starter-section section">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>Kirim Ulasan</h2>
                    <p>Bagikan pengalaman Anda menyewa di kontrakan Bu Sri</p>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <form action="{{ route('user.ulasan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label>Pesan</label>
                                <textarea name="pesan" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label>Rating</label>
                                <select name="rating" class="form-select" required>
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Gambar (opsional)</label>
                                <input type="file" name="gambar" class="form-control">
                            </div>

                            <button class="btn btn-success"><i class="bi bi-send"></i> Kirim Ulasan</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif






@endsection
