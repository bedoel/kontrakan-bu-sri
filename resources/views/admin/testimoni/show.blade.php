@extends('admin.layouts.app')

@section('title', 'Detail Ulasan - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Detail Ulasan</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row gy-4">
                <!-- Kolom Kiri: Info User -->
                <div class="col-md-7">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>Nama User:</strong> {{ $testimoni->user->name }}
                        </li>
                        <li class="list-group-item">
                            <strong>Rating:</strong>
                            <span class="badge bg-warning text-dark">{{ $testimoni->rating }} / 5</span>
                        </li>
                        <li class="list-group-item">
                            <strong>Pesan:</strong><br>
                            <div class="mt-2">{{ $testimoni->pesan }}</div>
                        </li>
                    </ul>
                </div>

                <!-- Kolom Kanan: Gambar -->
                @if ($testimoni->gambar)
                    <div class="col-md-5 text-center">
                        <h6 class="fw-bold">Gambar</h6>
                        <img src="{{ asset('storage/' . $testimoni->gambar) }}" class="img-fluid rounded shadow-sm border"
                            style="max-height: 300px; object-fit: contain;" alt="Gambar Testimoni">
                    </div>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ route('admin.testimoni.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
@endsection
