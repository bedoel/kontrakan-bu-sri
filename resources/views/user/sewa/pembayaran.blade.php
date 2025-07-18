@extends('user.layouts.app')

@section('title', 'Form Pembayaran')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-bg2.jpeg') }}');">
        <div class="container position-relative">
            <h1>Form Pembayaran</h1>
            <p>Silakan unggah bukti pembayaran Anda</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Pembayaran</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Page Title -->

    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Pembayaran Sewa</h2>
            <p>Lengkapi informasi pembayaran berikut</p>
        </div>

        <div class="container" data-aos="fade-up">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow">
                <div class="card-body">
                    <form action="{{ route('user.transaksi.store', $sewa->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Kontrakan</label>
                            <input type="text" class="form-control" value="{{ $sewa->kontrakan->nama }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Total Bayar (Rp)</label>
                            @php
                                use Carbon\Carbon;
                                $mulai = Carbon::parse($sewa->tanggal_mulai);
                                $akhir = Carbon::parse($sewa->tanggal_akhir);
                                $bulan = $mulai->diffInMonths($akhir);
                                $harga = $sewa->kontrakan->harga;
                                $diskon = $bulan >= 3 ? 0.05 : 0;
                                $totalBayar = $harga * $bulan;
                                $potongan = $totalBayar * $diskon;
                                $totalBayar -= $potongan;
                            @endphp
                            <input type="text" class="form-control" value="Rp {{ number_format($totalBayar) }}" disabled>
                            @if ($diskon)
                                <small class="text-success">Diskon 5% karena sewa lebih dari 3 bulan (Rp
                                    {{ number_format($potongan) }})</small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="metode" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="cash">Bayar Cash</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bukti Transfer</label>
                            <input type="file" name="bukti_transfer" class="form-control">
                            <small class="text-muted">Hanya jika memilih metode transfer</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Opsional..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-credit-card-2-back"></i> Kirim Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
