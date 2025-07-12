@extends('admin.layouts.app')

@section('title', 'Edit Profil - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Profil Admin</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
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

                <div class="row">
                    <!-- Kolom Kiri: Foto Profil -->
                    <div class="col-md-4 text-center mb-4">
                        <div class="mb-3">
                            @if ($admin->poto_profil)
                                <img src="{{ asset('storage/' . $admin->poto_profil) }}" alt="Foto Profil"
                                    class="rounded-circle img-thumbnail"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&size=150"
                                    alt="Avatar" class="rounded-circle img-thumbnail">
                            @endif
                        </div>
                        <input type="file" name="poto_profil" class="form-control">
                        <small class="text-muted d-block mt-2">Unggah untuk mengganti foto</small>
                    </div>

                    <!-- Kolom Kanan: Form -->
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', $admin->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $admin->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" name="nomor_hp" class="form-control"
                                value="{{ old('nomor_hp', $admin->nomor_hp) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password Baru <small class="text-muted">(Kosongkan jika tidak ingin
                                    mengubah)</small></label>
                            <input type="password" name="password" class="form-control" placeholder="********">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="********">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
