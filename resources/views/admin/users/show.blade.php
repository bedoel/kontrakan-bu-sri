@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 text-center text-md-start">Detail Penyewa</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row gy-4 align-items-center">
                    <div class="col-12 col-md-3 text-center">
                        @if ($user->poto_profil)
                            <img src="{{ asset('storage/' . $user->poto_profil) }}"
                                class="img-thumbnail rounded-circle shadow"
                                style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=150"
                                class="img-thumbnail rounded-circle shadow" alt="Avatar">
                        @endif
                    </div>

                    <div class="col-12 col-md-9">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th class="text-muted">Nama</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Nomor HP</th>
                                    <td>{{ $user->nomor_hp ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Email Terverifikasi</th>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span class="badge bg-success">Terverifikasi</span>
                                        @else
                                            <span class="badge bg-secondary">Belum</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Responsive --}}
        <div class="d-grid d-md-flex justify-content-md-start">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100 w-md-auto">
                <i class="bi bi-arrow-left-circle"></i> Kembali
            </a>
        </div>
    </div>
@endsection
