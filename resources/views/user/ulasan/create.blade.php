@extends('user.layouts.app')

@section('title', 'Buat Ulasan')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Buat Ulasan</h1>
            <p>Berikan penilaian dan pengalaman Anda menyewa kontrakan</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li><a href="{{ route('user.ulasan.index') }}">Ulasan</a></li>
                    <li class="current">Buat</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Kirim Ulasan</h2>
            <p>Isi form berikut untuk berbagi pengalaman Anda</p>
        </div>

        <div class="container" data-aos="fade-up">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.ulasan.store') }}" method="POST" enctype="multipart/form-data"
                class="card shadow-sm p-4 border-0">
                @csrf

                <div class="mb-3">
                    <label for="rating" class="form-label">Rating (1–5)</label>
                    <select name="rating" id="rating" class="form-select" required>
                        <option value="">-- Pilih Rating --</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} - {{ str_repeat('★', $i) }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan Ulasan</label>
                    <textarea name="pesan" id="pesan" rows="4" class="form-control" required
                        placeholder="Ceritakan pengalaman Anda...">{{ old('pesan') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar (Opsional)</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                    <small class="text-muted">Ukuran maksimal 2MB</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('user.ulasan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <button class="btn btn-primary">
                        <i class="bi bi-send-check"></i> Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
