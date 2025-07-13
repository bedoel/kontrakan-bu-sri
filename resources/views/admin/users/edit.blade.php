@extends('admin.layouts.app')

@section('title', 'Edit Penyewa - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Data Penyewa</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
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
                    <div class="col-md-4 text-center mb-3">
                        @if ($user->poto_profil)
                            <img src="{{ asset('storage/' . $user->poto_profil) }}"
                                class="img-thumbnail rounded-circle mb-3"
                                style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=150"
                                class="img-thumbnail rounded-circle mb-3" alt="Avatar">
                        @endif
                        <input type="file" name="poto_profil" class="form-control">
                        <small class="text-muted d-block mt-2">Upload jika ingin mengganti</small>
                    </div>

                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nomor HP</label>
                            <input name="nomor_hp" class="form-control" value="{{ $user->nomor_hp }}">
                        </div>

                        <hr>
                        <h6 class="text-danger">Ubah Password (Opsional)</h6>
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password baru">
                        </div>
                        <div class="mb-3">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Konfirmasi password">
                        </div>
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
