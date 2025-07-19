@extends('admin.layouts.app')

@section('title', 'Kelola Ulasan - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Kelola Ulasan</h1>

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
                            <th>Pesan</th>
                            <th>Rating</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ulasans as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $t->user->name }}</td>
                                <td>{{ Str::limit($t->pesan, 50) }}</td>
                                <td>{{ $t->rating }}/5</td>
                                <td>
                                    @if ($t->gambar)
                                        <img src="{{ asset('storage/' . $t->gambar) }}" width="60" class="img-thumbnail">
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.ulasan.show', $t->slug) }}"
                                        class="btn btn-sm btn-info">Lihat</a>
                                    <form action="{{ route('admin.ulasan.destroy', $t->slug) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus ulasan ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
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
