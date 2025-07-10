@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Daftar Sewa</h1>
        <div>
            <a href="{{ route('admin.laporan.sewa.excel') }}" class="btn btn-sm btn-outline-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </a>
            <a href="{{ route('admin.laporan.sewa.pdf') }}" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.sewa.create') }}" class="btn btn-primary">
            Tambah Sewa
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama User</th>
                            <th>Kontrakan</th>
                            <th>Mulai</th>
                            <th>Akhir</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sewas as $sewa)
                            <tr>
                                <td>{{ $sewa->user->name }}</td>
                                <td>{{ $sewa->kontrakan->nama }}</td>
                                <td>{{ $sewa->tanggal_mulai->format('d M Y') }}</td>
                                <td>{{ $sewa->tanggal_akhir->format('d M Y') }}</td>
                                <td>{!! statusBadge($sewa->status) !!}</td>
                                <td>
                                    <a href="{{ route('admin.sewa.show', $sewa->id) }}"
                                        class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('admin.sewa.edit', $sewa->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <a href="{{ route('admin.sewa.perpanjang.form', $sewa->id) }}"
                                        class="btn btn-success btn-sm">Perpanjang</a>
                                    <form action="{{ route('admin.sewa.destroy', $sewa->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin hapus?')">Hapus</button>
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
