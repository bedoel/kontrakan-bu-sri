@extends('user.layouts.app')

@section('title', 'Detail Sewa')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-bg2.jpeg') }}');">
        <div class="container position-relative">
            <h1>Detail Sewa</h1>
            <p>Informasi lengkap tentang kontrakan yang disewa</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Detail Sewa</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Detail Section -->
    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Informasi Sewa</h2>
            <p>Berikut adalah detail dari penyewaan Anda.</p>
        </div>

        <div class="container" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Kontrakan: {{ $sewa->kontrakan->nama }}</h5>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Tanggal Mulai:</strong>
                            {{ \Carbon\Carbon::parse($sewa->tanggal_mulai)->format('d M Y') }}
                        </li>
                        <li class="list-group-item"><strong>Tanggal Akhir:</strong>
                            {{ \Carbon\Carbon::parse($sewa->tanggal_akhir)->format('d M Y') }}
                        </li>
                        <li class="list-group-item"><strong>Status:</strong>
                            {!! statusBadge($sewa->status) !!}
                        </li>
                        <li class="list-group-item"><strong>Harga / Bulan:</strong>
                            Rp {{ number_format($sewa->kontrakan->harga) }}
                        </li>
                        <li class="list-group-item"><strong>Lama Sewa:</strong>
                            {{ $sewa->lama_sewa_bulan }} bulan
                        </li>
                        <li class="list-group-item"><strong>Total Sebelum Diskon:</strong>
                            Rp {{ number_format($sewa->kontrakan->harga * $sewa->lama_sewa_bulan) }}
                        </li>
                        <li class="list-group-item"><strong>Diskon:</strong>
                            Rp {{ number_format($sewa->diskon ?? 0) }}
                        </li>
                        @if ($sewa->denda > 0)
                            <li class="list-group-item"><strong>Denda:</strong>
                                Rp {{ number_format($sewa->denda ?? 0) }}
                            </li>
                        @endif
                        <li class="list-group-item"><strong>Total yang harus dibayar:</strong>
                            Rp
                            {{ number_format($sewa->kontrakan->harga * $sewa->lama_sewa_bulan - ($sewa->diskon ?? 0) + ($sewa->denda ?? 0)) }}
                        </li>
                    </ul>

                    <a href="{{ route('user.sewa.index') }}" class="btn btn-secondary mt-4">Kembali</a>

                    @if ($sewa->status === 'menunggu_pembayaran' && !$sewa->transaksi)
                        <div class="mt-4">
                            <a href="{{ route('user.transaksi.create', $sewa->id) }}" class="btn btn-success w-100">
                                <i class="bi bi-credit-card"></i> Lanjut ke Pembayaran
                            </a>
                        </div>
                    @endif
                    @if (in_array($sewa->status, ['menunggu_pembayaran']))
                        <form action="{{ route('user.sewa.batal', $sewa->id) }}" method="POST" class="mt-3">
                            @csrf @method('PUT')
                            <button class="btn btn-danger w-100"
                                onclick="return confirm('Yakin ingin membatalkan sewa ini?')">
                                <i class="bi bi-x-circle"></i> Batalkan Sewa
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </section>
@endsection
