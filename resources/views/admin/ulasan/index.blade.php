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
                                        class="btn btn-info btn-icon-split btn-sm">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <span class="text">Detail</span>
                                    </a>
                                    <div class="my-2"></div>
                                    <form action="{{ route('admin.ulasan.destroy', $t->slug) }}" method="POST"
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
