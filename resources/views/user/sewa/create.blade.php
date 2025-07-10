@extends('user.layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Sewa Kontrakan</h1>
            <p>Isi form di bawah ini untuk mengajukan penyewaan kontrakan.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Sewa</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Form Section -->
    <section id="starter-section" class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Form Sewa Kontrakan</h2>
            <p>Silakan isi informasi penyewaan</p>
        </div>

        <div class="container" data-aos="fade-up">
            <div class="mb-4">
                <h4>{{ $kontrakan->nama }}</h4>
                <p><strong>Harga:</strong> Rp <span id="harga">{{ number_format($kontrakan->harga) }}</span> / bulan</p>
                <p><strong>Status:</strong>
                    {!! statusBadge($kontrakan->status) !!}
                </p>
            </div>

            <form action="{{ route('user.sewa.store') }}" method="POST">
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
                <input type="hidden" name="kontrakan_id" value="{{ $kontrakan->id }}">
                <input type="hidden" id="hargaRaw" value="{{ $kontrakan->harga }}">

                <div class="mb-3">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Sewa</label>
                    <input type="date" class="form-control" name="tanggal_mulai" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah_bulan" class="form-label">Lama Sewa (bulan)</label>
                    <select name="jumlah_bulan" id="jumlah_bulan" class="form-control" required>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }} bulan</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diskon</label>
                    <input type="text" id="diskon" class="form-control" readonly value="Rp 0">
                </div>

                <div class="mb-3">
                    <label class="form-label">Total Bayar</label>
                    <input type="text" id="total_bayar" class="form-control" readonly>
                </div>

                <button type="submit" class="btn btn-primary">Ajukan Sewa</button>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(angka);
        }

        function hitungTotal() {
            const harga = parseInt(document.getElementById('hargaRaw').value);
            const bulan = parseInt(document.getElementById('jumlah_bulan').value);

            let diskonPerBulan = 0;

            if (bulan >= 6) {
                diskonPerBulan = 50000;
            } else if (bulan >= 3) {
                diskonPerBulan = 25000;
            }

            const totalDiskon = diskonPerBulan * bulan;
            const totalBayar = (harga * bulan) - totalDiskon;

            document.getElementById('diskon').value = formatRupiah(totalDiskon);
            document.getElementById('total_bayar').value = formatRupiah(totalBayar);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('jumlah_bulan').addEventListener('change', hitungTotal);
            hitungTotal(); // Hitung awal
        });
    </script>
@endpush
