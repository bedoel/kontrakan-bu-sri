@extends('admin.layouts.app')

@section('title', 'Tambah Penyewa - Admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 text-center text-md-start">Tambah Penyewa Baru</h1>


        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') }}" placeholder="Nama lengkap" required>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email') }}" placeholder="Alamat email" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nomor_hp" class="form-label">Nomor HP</label>
                            <input type="text" name="nomor_hp" id="nomor_hp" class="form-control"
                                value="{{ old('nomor_hp') }}" placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="col-md-6">
                            <label for="poto_profil" class="form-label">Foto Profil <small
                                    class="text-muted">(opsional)</small></label>
                            <input type="file" name="poto_profil" id="poto_profil" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Minimal 8 karakter" required>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required placeholder="Ulangi password">
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="d-grid gap-3 d-md-none">
                            {{-- Tampilan MOBILE: Stack dengan jarak --}}
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <div class="my-2"></div>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>

                        <div class="d-none d-md-flex justify-content-between gap-3">
                            {{-- Tampilan DESKTOP: Horizontal sejajar --}}
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
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
