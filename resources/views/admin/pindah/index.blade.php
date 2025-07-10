@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Daftar Permintaan Pindah</h1>
        <div>
            <a href="{{ route('admin.laporan.pindah.excel') }}" class="btn btn-sm btn-outline-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </a>
            <a href="{{ route('admin.laporan.pindah.pdf') }}" class="btn btn-sm btn-outline-danger">
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

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama User</th>
                            <th>Kontrakan Lama</th>
                            <th>Kontrakan Baru</th>
                            <th>Alasan</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permintaan as $p)
                            <tr>
                                <td>{{ $p->user->name }}</td>
                                <td>{{ $p->kontrakanLama->nama }}</td>
                                <td>{{ $p->kontrakanBaru->nama }}</td>
                                <td>{{ $p->alasan }}</td>
                                <td>{!! statusBadge($p->status) !!}</td>
                                <td>{{ $p->catatan ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.pindah.show', $p->id) }}"
                                        class="btn btn-sm btn-info mb-1">Detail</a>

                                    @if ($p->status == 'menunggu')
                                        <form action="{{ route('admin.pindah.destroy', $p->id) }}" method="POST"
                                            onsubmit="return confirmDelete(this)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(form) {
            event.preventDefault();
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini tidak dapat dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endpush
