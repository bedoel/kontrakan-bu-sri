@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Tambah Kontrakan</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.kontrakan.store') }}" method="POST" enctype="multipart/form-data">
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
                        <select name="status" id="status" class="form-control">
                            <option value="tersedia" selected>Tersedia</option>
                            <option value="disewa">Disewa</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="foto_kontrakans" class="form-label">Foto Kontrakan</label>
                        <input type="file" name="foto_kontrakans[]" id="foto_kontrakans" class="form-control" multiple>
                        <small class="text-muted">Anda dapat mengunggah lebih dari satu foto (maks 2MB per file).</small>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.kontrakan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Kontrakan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
