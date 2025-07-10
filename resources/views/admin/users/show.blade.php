@extends('admin.layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Detail User</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <!-- Foto Profil -->
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    @if ($user->poto_profil)
                        <img src="{{ asset('storage/' . $user->poto_profil) }}" class="img-thumbnail rounded-circle shadow"
                            style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=150"
                            class="img-thumbnail rounded-circle shadow" alt="Avatar">
                    @endif
                </div>

                <!-- Info User -->
                <div class="col-md-9">
                    <table class="table table-borderless">
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
                                    <span class="badge bg-success text-white">Terverifikasi</span>
                                @else
                                    <span class="badge bg-secondary text-white">Belum</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Reset Password -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-danger">Reset Password</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST">
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
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="password" name="password" class="form-control" placeholder="Password baru" required>
                    </div>
                    <div class="col-md-6">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Konfirmasi password" required>
                    </div>
                </div>
                <button class="btn btn-danger mt-3">Reset Password</button>
            </form>
        </div>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Kembali
    </a>
@endsection
