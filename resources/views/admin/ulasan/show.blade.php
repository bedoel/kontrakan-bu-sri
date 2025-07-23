@extends('admin.layouts.app')

@section('title', 'Detail Ulasan - Admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 text-center text-md-start">Detail Ulasan</h1>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row gy-4">
                    <div class="col-12 col-md-7">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <strong>Nama User:</strong> {{ $ulasan->user->name }}
                            </li>
                            <li class="list-group-item">
                                <strong>Rating:</strong>
                                <span class="badge bg-warning text-dark">{{ $ulasan->rating }} / 5</span>
                            </li>
                            <li class="list-group-item">
                                <strong>Pesan:</strong>
                                <div class="mt-2 text-wrap">{{ $ulasan->pesan }}</div>
                            </li>
                        </ul>
                    </div>

                    @if ($ulasan->gambar)
                        <div class="col-12 col-md-5 text-center">
                            <h6 class="fw-bold">Gambar</h6>
                            <img src="{{ asset('storage/' . $ulasan->gambar) }}" class="img-fluid rounded border shadow-sm"
                                style="max-height: 300px; object-fit: contain;" alt="Gambar Ulasan">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-grid d-md-flex justify-content-md-start">
            <a href="{{ route('admin.ulasan.index') }}" class="btn btn-secondary w-100 w-md-auto">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </div>
@endsection
