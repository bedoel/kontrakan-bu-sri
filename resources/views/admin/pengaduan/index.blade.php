@extends('admin.layouts.app')

@section('title', 'Tanggapi Pengaduan - Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Daftar Pengaduan</h1>
        <div>
            <a href="{{ route('admin.laporan.pengaduan.excel') }}" class="btn btn-sm btn-outline-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </a>
            <a href="{{ route('admin.laporan.pengaduan.pdf') }}" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>User</th>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Balasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduans as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <img src="{{ $p->user->poto_profil ? asset('storage/' . $p->user->poto_profil) : 'https://ui-avatars.com/api/?name=' . urlencode($p->user->name) }}"
                                                alt="avatar" class="rounded-circle" width="32" height="32"
                                                style="object-fit: cover;">
                                        </div>
                                        <div>
                                            {{ $p->user->name }}
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Str::limit($p->pesan, 60) }}</td>
                                <td>
                                    {!! statusBadge($p->status) !!}
                                </td>
                                <td><span class="badge bg-info text-white">{{ $p->balasan->count() }} Balasan</span></td>
                                <td>
                                    <a href="{{ route('admin.pengaduan.show', $p->slug) }}"
                                        class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <span class="text">Detail</span>
                                    </a>
                                    <div class="my-2"></div>
                                    <form action="{{ route('admin.pengaduan.destroy', $p->slug) }}" method="POST"
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
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
