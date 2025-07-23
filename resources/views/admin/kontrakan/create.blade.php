@extends('admin.layouts.app')

@section('title', 'Tambah Kontrakan - Admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 text-center text-md-start">Tambah Kontrakan</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.kontrakan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kontrakan</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            placeholder="Masukkan nama kontrakan" required>
                    </div>

                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga / Bulan</label>
                        <input type="number" name="harga" id="harga" class="form-control"
                            placeholder="Contoh: 750000" required>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"
                            placeholder="Tulis deskripsi kontrakan..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Kontrakan</label>
                        <select name="status" id="status" class="form-select">
                            <option value="tersedia" selected>Tersedia</option>
                            <option value="disewa">Disewa</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto_kontrakans" class="form-label">Foto Kontrakan</label>
                        <input type="file" name="foto_kontrakans[]" id="foto_kontrakans" class="form-control" multiple>
                        <small class="text-muted">Anda dapat mengunggah lebih dari satu foto (maks 2MB per file).</small>
                    </div>

                    <div class="mt-4">
                        <div class="d-grid gap-3 d-md-none">
                            {{-- Tampilan MOBILE: Stack dengan jarak --}}
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <div class="my-2"></div>
                            <a href="{{ route('admin.kontrakan.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>

                        <div class="d-none d-md-flex justify-content-between gap-3">
                            {{-- Tampilan DESKTOP: Horizontal sejajar --}}
                            <a href="{{ route('admin.kontrakan.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
