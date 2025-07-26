@extends('admin.layouts.app')

@section('title', 'Kelola Admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Admin</h1>
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary btn-icon-split btn-sm mb-2">
            <span class="icon text-white-50">
                <i class="fas fa-user-plus"></i>
            </span>
            <span class="text">Tambah Admin</span>
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
                            <th>Role</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ $admin->poto_profil ? asset('storage/' . $admin->poto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($admin->name) }}"
                                                alt="avatar" class="rounded-circle" width="32" height="32"
                                                style="object-fit: cover;">
                                        </div>
                                        <div>{{ $admin->name }}</div>
                                    </div>
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @if ($admin->nomor_hp)
                                        {{ $admin->nomor_hp }}
                                    @else
                                        <span class="badge bg-secondary text-white">Belum diisi</span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge {{ $admin->role === 'super_admin' ? 'bg-danger' : 'bg-secondary' }} text-white">
                                        {{ ucfirst(str_replace('_', ' ', $admin->role)) }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('admin.admins.show', $admin->id) }}"
                                        class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <span class="text">Detail</span>
                                    </a>
                                    <div class="my-2"></div>
                                    <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                        class="btn btn-warning btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <div class="my-2"></div>
                                    @if (auth('admin')->user()->id !== $admin->id)
                                        <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST"
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
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data admin.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
