@extends('user.layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-bg2.jpeg') }}');">
        <div class="container position-relative">
            <h1>Detail Transaksi</h1>
            <p>Informasi lengkap transaksi penyewaan kontrakan.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li><a href="{{ route('user.transaksi.index') }}">Riwayat Transaksi</a></li>
                    <li class="current">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Transaksi Detail Section -->
    <section id="transaksi-detail" class="section">
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Informasi Transaksi</h2>
                <p>Detail transaksi sewa kontrakan Anda.</p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <ul class="list-group mb-4">
                        <li class="list-group-item"><strong>Invoice:</strong> {{ $transaksi->invoice_number }}</li>
                        <li class="list-group-item"><strong>Kontrakan:</strong> {{ $transaksi->sewa->kontrakan->nama }}</li>
                        <li class="list-group-item"><strong>Metode:</strong> {{ ucfirst($transaksi->metode) }}</li>
                        <li class="list-group-item"><strong>Total Bayar:</strong> Rp
                            {{ number_format($transaksi->total_bayar) }}</li>
                        <li class="list-group-item"><strong>Diskon:</strong> Rp {{ number_format($transaksi->diskon) }}</li>
                        <li class="list-group-item"><strong>Denda:</strong> Rp {{ number_format($transaksi->denda) }}</li>
                        <li class="list-group-item"><strong>Status:</strong>
                            <span>
                                {!! statusBadge($transaksi->status) !!}
                            </span>
                        </li>
                        <li class="list-group-item"><strong>Catatan:</strong> {{ $transaksi->catatan ?? '-' }}</li>
                    </ul>

                    @if ($transaksi->catatan)
                        <div class="alert alert-info mt-3">
                            <h5 class="mb-2"><i class="bi bi-chat-dots me-2"></i>Pesan dari Admin</h5>
                            <p class="mb-0">{{ $transaksi->pesan }}</p>
                        </div>
                    @endif


                    @if ($transaksi->bukti_transfer)
                        <div class="mb-4">
                            <h5>Bukti Transfer</h5>
                            <img src="{{ asset('storage/' . $transaksi->bukti_transfer) }}"
                                class="img-fluid rounded shadow" style="max-height: 300px;" alt="Bukti Transfer">
                        </div>
                    @endif

                    <a href="{{ route('user.transaksi.invoice', $transaksi->invoice_number) }}" target="_blank"
                        class="btn btn-primary">
                        <i class="bi bi-printer"></i> Cetak Invoice
                    </a>
                    <a href="{{ route('user.transaksi.index') }}" class="btn btn-secondary ms-2">Kembali</a>
                </div>
            </div>
        </div>
    </section>
@endsection
