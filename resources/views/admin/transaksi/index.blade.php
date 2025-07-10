@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Daftar Transaksi</h1>
        <div>
            <a href="{{ route('admin.laporan.transaksi.excel') }}" class="btn btn-sm btn-outline-success me-2">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </a>
            <a href="{{ route('admin.laporan.transaksi.pdf') }}" class="btn btn-sm btn-outline-danger">
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
        <div class="card shadow mb-4">
            <div class="card-body">
                <table class="table table-bordered datatable">
                    <thead class="table-dark">
                        <tr>
                            <th>Invoice</th>
                            <th>Penyewa</th> <!-- Tambahkan ini -->
                            <th>Kontrakan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $trx)
                            <tr>
                                <td>{{ $trx->invoice_number }}</td>
                                <td>
                                    @if ($trx->sewa && $trx->sewa->user)
                                        <a href="{{ route('admin.users.show', $trx->sewa->user->id) }}">
                                            {{ $trx->sewa->user->name }}
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>{{ $trx->sewa->kontrakan->nama }}</td>
                                <td>Rp {{ number_format($trx->total_bayar) }}</td>
                                <td>{!! statusBadge($trx->status) !!}</td>
                                <td>
                                    <a href="{{ route('admin.transaksi.edit', $trx->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('admin.transaksi.destroy', $trx->id) }}" method="POST"
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
