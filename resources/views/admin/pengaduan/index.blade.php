@extends('admin.layouts.app')

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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif
    <div class="table-responsive">
        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">User</th>
                            <th scope="col">Pesan</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ubah Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduans as $p)
                            <tr>
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
                                <td>
                                    <form action="{{ route('admin.pengaduan.ubah-status', $p->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-control form-select-sm"
                                            onchange="this.form.submit()">
                                            <option disabled selected>Ubah...</option>
                                            <option value="menunggu" {{ $p->status == 'menunggu' ? 'selected' : '' }}>
                                                Menunggu
                                            </option>
                                            <option value="diproses" {{ $p->status == 'diproses' ? 'selected' : '' }}>
                                                Diproses
                                            </option>
                                            <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('admin.pengaduan.show', $p->id) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
