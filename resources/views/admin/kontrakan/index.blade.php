@extends('admin.layouts.app')

@section('title', 'Kelola Kontrakan - Admin')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kontrakan</h1>
        <a href="{{ route('admin.kontrakan.create') }}" class="btn btn-primary btn-icon-split btn-sm mb-2">
            <span class="icon text-white-50">
                <i class="fas fa-home"></i>
            </span>
            <span class="text">Tambah Kontrakan</span>
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Disewa Oleh</th>
                            <th>Ditambahkan Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kontrakans as $kontrakan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kontrakan->nama }}</td>
                                <td>Rp {{ number_format($kontrakan->harga) }}</td>
                                <td>{!! statusBadge($kontrakan->status) !!}</td>
                                <td>
                                    {{ $kontrakan->sewaAktif ? $kontrakan->sewaAktif->user->name : '-' }}
                                </td>
                                <td>
                                    {{ $kontrakan->admin->name ?? '-' }}
                                </td>

                                <td>
                                    <a href="{{ route('admin.kontrakan.edit', $kontrakan->slug) }}"
                                        class="btn btn-warning btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-edit"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <div class="my-2"></div>
                                    <form action="{{ route('admin.kontrakan.destroy', $kontrakan->slug) }}" method="POST"
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
