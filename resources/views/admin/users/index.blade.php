@extends('admin.layouts.app')

@section('title', 'Kelola Penyewa - Admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Penyewa</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-icon-split btn-sm mb-2">
            <span class="icon text-white-50">
                <i class="fas fa-user-plus"></i>
            </span>
            <span class="text">Tambah User</span>
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor HP</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ $u->poto_profil ? asset('storage/' . $u->poto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($u->name) }}"
                                                alt="avatar" class="rounded-circle" width="32" height="32"
                                                style="object-fit: cover;">
                                        </div>
                                        <div>
                                            {{ $u->name }}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    @if ($u->nomor_hp)
                                        {{ $u->nomor_hp }}
                                    @else
                                        <span class="badge bg-secondary text-white">Belum diisi</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('admin.users.show', $u->id) }}"
                                        class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <span class="text">Detail</span>
                                    </a>
                                    <div class="my-2"></div>
                                    <a href="{{ route('admin.users.edit', $u->id) }}"
                                        class="btn btn-warning btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <div class="my-2"></div>
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-icon-split btn-sm"
                                            onclick="return confirm('Yakin hapus?')">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">Hapus</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data user.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
