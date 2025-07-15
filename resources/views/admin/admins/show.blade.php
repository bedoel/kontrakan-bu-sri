@extends('admin.layouts.app')

@section('title', 'Detail Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Detail Admin</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    @if ($admin->poto_profil)
                        <img src="{{ asset('storage/' . $admin->poto_profil) }}" class="img-thumbnail rounded-circle shadow"
                            style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&size=150"
                            class="img-thumbnail rounded-circle shadow" alt="Avatar">
                    @endif
                </div>

                <div class="col-md-9">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-muted">Nama</th>
                            <td>{{ $admin->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Email</th>
                            <td>{{ $admin->email }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Nomor HP</th>
                            <td>{{ $admin->nomor_hp ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Role</th>
                            <td>
                                <span
                                    class="badge {{ $admin->role === 'super_admin' ? 'bg-danger' : 'bg-secondary' }} text-white">
                                    {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
@endsection
