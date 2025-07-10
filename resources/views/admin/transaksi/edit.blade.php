@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Konfirmasi Transaksi</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Detail Transaksi</h5>
            </div>
            <div class="card-body">
                <div class="row g-4">

                    <!-- Kiri: Detail Transaksi -->
                    <div class="col-md-7">
                        <table class="table table-borderless">
                            <tr>
                                <th>Invoice</th>
                                <td>{{ $transaksi->invoice_number }}</td>
                            </tr>
                            <tr>
                                <th>Metode Pembayaran</th>
                                <td>{{ ucfirst($transaksi->metode) }}</td>
                            </tr>
                            <tr>
                                <th>Denda</th>
                                <td>Rp {{ number_format($transaksi->denda) }}</td>
                            </tr>
                            <tr>
                                <th>Diskon</th>
                                <td>Rp {{ number_format($transaksi->diskon) }}</td>
                            </tr>
                            <tr>
                                <th>Total Bayar</th>
                                <td class="fw-bold text-success">Rp {{ number_format($transaksi->total_bayar) }}</td>
                            </tr>
                            <tr>
                                <th>Catatan</th>
                                <td>{{ $transaksi->catatan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Kanan: Bukti Transfer -->
                    @if ($transaksi->bukti_transfer)
                        <div class="col-md-5 text-center">
                            <p class="fw-bold mb-2">Bukti Transfer</p>
                            <img src="{{ asset('storage/' . $transaksi->bukti_transfer) }}" class="img-fluid rounded border"
                                style="max-height: 250px; object-fit: contain;" alt="Bukti Transfer">
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Form Konfirmasi -->
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="bi bi-pencil-square"></i> Form Konfirmasi</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.transaksi.update', $transaksi->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Status Transaksi</label>
                        <select name="status" class="form-control">
                            <option value="menunggu_konfirmasi"
                                {{ $transaksi->status == 'menunggu_konfirmasi' ? 'selected' : '' }}>
                                Menunggu Konfirmasi
                            </option>
                            <option value="disetujui" {{ $transaksi->status == 'disetujui' ? 'selected' : '' }}>
                                Disetujui
                            </option>
                            <option value="ditolak" {{ $transaksi->status == 'ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pesan / Catatan Tambahan</label>
                        <textarea name="pesan" class="form-control" rows="3">{{ old('pesan', $transaksi->pesan) }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
