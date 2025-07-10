@extends('admin.layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Kelola Testimoni</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Pesan</th>
                            <th>Rating</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonis as $t)
                            <tr>
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
                                    <a href="{{ route('admin.testimoni.show', $t->id) }}"
                                        class="btn btn-sm btn-info">Lihat</a>
                                    <form action="{{ route('admin.testimoni.destroy', $t->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Hapus testimoni ini?')">
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
