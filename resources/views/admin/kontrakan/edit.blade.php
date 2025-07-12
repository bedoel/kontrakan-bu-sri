@extends('admin.layouts.app')

@section('title', 'Edit Kontrakan - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Kontrakan</h1>

    <form action="{{ route('admin.kontrakan.update', $kontrakan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label>Nama Kontrakan</label>
            <input type="text" name="nama" class="form-control" value="{{ $kontrakan->nama }}" required>
        </div>
        <div class="form-group">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $kontrakan->harga }}" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="4">{{ $kontrakan->deskripsi }}</textarea>
        </div>
        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="tersedia" {{ $kontrakan->status == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="disewa" {{ $kontrakan->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
            </select>
        </div>

        <div class="form-group">
            <label>Tambah Foto Baru (Opsional)</label>
            <input type="file" name="foto_kontrakans[]" class="form-control" multiple>
        </div>

        @if ($kontrakan->foto_kontrakans->count())
            <div class="form-group">
                <label>Foto Tersimpan:</label>
                <div class="row">
                    @foreach ($kontrakan->foto_kontrakans as $foto)
                        <div class="col-md-3 mb-2">
                            <img src="{{ asset('storage/' . $foto->path) }}" class="img-fluid">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('admin.kontrakan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
