@extends('admin.layouts.app')

@section('title', 'Kelola Penyewa - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Kelola Penyewa</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            Tambah User
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor HP</th>
                            <th style="width: 180px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $u)
                            <tr>
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
                                    <a href="{{ route('admin.users.show', $u->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('admin.users.edit', $u->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
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
