@extends('user.layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Detail Pengaduan</h1>
            <p>Lihat status dan balasan dari admin</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Pengaduan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Detail Section -->
    <section class="starter-section section">
        <div class="container" data-aos="fade-up">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Status:
                        {!! statusBadge($pengaduan->status) !!}
                    </h5>
                    <p>{{ $pengaduan->pesan }}</p>
                    @if ($pengaduan->gambar)
                        <img src="{{ asset('storage/' . $pengaduan->gambar) }}" class="img-fluid mt-3 rounded"
                            style="max-width: 300px;">
                    @endif
                </div>
            </div>

            <h5 class="mb-3">Balasan</h5>
            @forelse($pengaduan->balasan as $balas)
                <div class="border rounded p-3 mb-2">
                    <strong>{{ $balas->admin ? 'Admin' : 'Anda' }}</strong>:
                    <p class="mb-0">{{ $balas->pesan }}</p>
                </div>
            @empty
                <div class="alert alert-info">Belum ada balasan untuk pengaduan ini.</div>
            @endforelse

            <hr class="my-4">

            <h5>Balas Pengaduan</h5>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('user.pengaduan.balas', $pengaduan->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="pesanBalasan" class="form-label">Pesan Anda</label>
                    <textarea name="pesan" id="pesanBalasan" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-success"><i class="bi bi-reply"></i> Kirim Balasan</button>
            </form>


            <a href="{{ route('user.pengaduan.index') }}" class="btn btn-secondary mt-4">Kembali</a>
        </div>
    </section>
@endsection
