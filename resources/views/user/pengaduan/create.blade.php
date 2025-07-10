@extends('user.layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Buat Pengaduan</h1>
            <p>Ajukan keluhan atau laporan kepada admin</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Pengaduan</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Form Pengaduan</h2>
            <p>Silakan tulis pesan Anda di bawah ini</p>
        </div>

        <div class="container" data-aos="fade-up">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('user.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
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
                        <div class="mb-3">
                            <label for="pesan" class="form-label">Pesan</label>
                            <textarea name="pesan" id="pesan" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar Pendukung (Opsional)</label>
                            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                        </div>
                        <button class="btn btn-primary"><i class="bi bi-send"></i> Kirim Pengaduan</button>
                        <a href="{{ route('user.pengaduan.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
