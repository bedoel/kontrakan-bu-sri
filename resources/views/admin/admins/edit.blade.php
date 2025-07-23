@extends('admin.layouts.app')

@section('title', 'Edit Admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 text-center text-md-start">Edit Data Admin</h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
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

                    <div class="row gy-4">
                        <div class="col-12 col-md-4 text-center">
                            @if ($admin->poto_profil)
                                <img src="{{ asset('storage/' . $admin->poto_profil) }}"
                                    class="img-thumbnail rounded-circle shadow mb-3"
                                    style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&size=150"
                                    class="img-thumbnail rounded-circle shadow mb-3" alt="Avatar">
                            @endif
                            <input type="file" name="poto_profil" class="form-control">
                            <small class="text-muted d-block mt-2">Upload jika ingin mengganti</small>
                        </div>

                        <div class="col-12 col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input name="name" class="form-control" value="{{ $admin->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" value="{{ $admin->email }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <input name="nomor_hp" class="form-control" value="{{ $admin->nomor_hp }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Role</label>
                                <select name="role" class="form-control" required>
                                    <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="super_admin" {{ $admin->role == 'super_admin' ? 'selected' : '' }}>Super
                                        Admin</option>
                                </select>
                            </div>

                            <hr class="my-4">
                            <h6 class="text-danger mb-3">Ubah Password (Opsional)</h6>
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

                    <div class="mt-4">
                        <div class="d-grid gap-3 d-md-none">
                            {{-- Tampilan MOBILE: Stack dengan jarak --}}
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <div class="my-2"></div>
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>

                        <div class="d-none d-md-flex justify-content-between gap-3">
                            {{-- Tampilan DESKTOP: Horizontal sejajar --}}
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
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
