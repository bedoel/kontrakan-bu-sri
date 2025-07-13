@extends('user.layouts.app')

@section('title', 'Pengajuan Pindah Kontrakan')

@section('content')
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('assets/img/page-title-bg.webp') }}');">
        <div class="container position-relative">
            <h1>Pengajuan Pindah Kontrakan</h1>
            <p>Ajukan permintaan pindah kontrakan Anda secara langsung.</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Pengajuan Pindah</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Section -->
    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Form Pindah Kontrakan</h2>
            <p>Silakan isi form berikut untuk mengajukan pindah ke kontrakan lain.</p>
        </div>

        <div class="container" data-aos="fade-up">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('user.pindah.store') }}" method="POST">
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
                            <label for="kontrakan_baru_id" class="form-label">Kontrakan Baru</label>
                            <select name="kontrakan_baru_id" id="kontrakan_baru_id" class="form-select" required>
                                <option value="">-- Pilih Kontrakan --</option>
                                @foreach ($kontrakans as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="alasan" class="form-label">Alasan Pindah</label>
                            <textarea name="alasan" id="alasan" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send"></i> Ajukan Pindah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
