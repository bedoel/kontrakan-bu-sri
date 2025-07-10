@extends('admin.layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Kontrakan</h1>
        <a href="{{ route('admin.kontrakan.create') }}" class="btn btn-sm btn-primary">Tambah Kontrakan</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Kontrakan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered datatable" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kontrakans as $kontrakan)
                            <tr>
                                <td>{{ $kontrakan->nama }}</td>
                                <td>Rp {{ number_format($kontrakan->harga) }}</td>
                                <td>{!! statusBadge($kontrakan->status) !!}</td>
                                <td>
                                    <a href="{{ route('admin.kontrakan.edit', $kontrakan->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.kontrakan.destroy', $kontrakan->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
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
