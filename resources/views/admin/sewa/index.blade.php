@extends('admin.layouts.app')

@section('title', 'Kelola Sewa - Admin')

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
        <a href="{{ route('admin.sewa.create') }}" class="btn btn-primary btn-icon-split btn-sm mb-2">
            <span class="icon text-white-50">
                <i class="fas fa-file-signature"></i>
            </span>
            <span class="text">Tambah Sewa</span>
        </a>
    </div>


    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama User</th>
                            <th>Kontrakan</th>
                            <th>Mulai</th>
                            <th>Akhir</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sewas as $sewa)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sewa->user->name }}</td>
                                <td>{{ $sewa->kontrakan->nama }}</td>
                                <td>{{ $sewa->tanggal_mulai->format('d M Y') }}</td>
                                <td>{{ $sewa->tanggal_akhir->format('d M Y') }}</td>
                                <td>{!! statusBadge($sewa->status) !!}</td>
                                <td>
                                    {{ $sewa->admin ? $sewa->admin->name : '-' }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.sewa.show', $sewa->slug) }}"
                                        class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <span class="text">Detail</span>
                                    </a>
                                    <div class="my-2"></div>
                                    <a href="{{ route('admin.sewa.edit', $sewa->slug) }}"
                                        class="btn btn-warning btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <div class="my-2"></div>
                                    <a href="{{ route('admin.sewa.perpanjang.form', $sewa->slug) }}"
                                        class="btn btn-success btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-redo"></i>
                                        </span>
                                        <span class="text">Perpanjang</span>
                                    </a>
                                    <div class="my-2"></div>
                                    <form action="{{ route('admin.sewa.destroy', $sewa->slug) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-icon-split btn-sm"
                                            onclick="return confirm('Yakin hapus?')"><span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span><span class="text">Hapus</span></button>
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
