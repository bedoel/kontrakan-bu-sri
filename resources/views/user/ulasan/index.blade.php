@extends('user.layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Ulasan Saya</h1>
            <p>Berikan pendapat dan pengalaman Anda selama menyewa kontrakan</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Ulasan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Ulasan Section -->
    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Ulasan Anda</h2>
            <p>Lihat dan kelola ulasan yang sudah Anda kirim</p>
        </div>

        <div class="container" data-aos="fade-up">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3 text-end">
                <a href="{{ route('user.ulasan.create') }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square me-1"></i> Buat Ulasan
                </a>
            </div>

            @forelse($ulasans as $t)
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-1">
                                <span class="text-warning">{{ str_repeat('★', $t->rating) }}</span>
                                <span class="text-muted small ms-2">({{ $t->rating }}/5)</span>
                            </h5>
                            <p class="mb-2">{{ $t->pesan }}</p>
                            <div class="d-flex align-items-center mt-3">
                                <a href="{{ route('user.ulasan.edit', $t->id) }}" class="btn btn-sm btn-warning me-2">
                                    Edit
                                </a>
                                <form action="{{ route('user.ulasan.destroy', $t->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus ulasan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </div>
                        </div>
                        @if ($t->gambar)
                            <img src="{{ asset('storage/' . $t->gambar) }}" class="img-thumbnail mt-3 mt-md-0"
                                style="width: 120px; object-fit: cover;">
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info">Belum ada ulasan yang dikirim.</div>
            @endforelse
        </div>
    </section>
@endsection
