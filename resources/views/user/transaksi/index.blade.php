@extends('user.layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Riwayat Transaksi</h1>
            <p>Berikut adalah data transaksi penyewaan Anda</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Riwayat Transaksi</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Page Title -->

    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Riwayat Transaksi</h2>
            <p>Data transaksi yang telah Anda lakukan</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="table table-bordered align-middle datatable" id="transaksiTable">

                <thead class="table-light">
                    <tr>
                        <th>Invoice</th>
                        <th>Kontrakan</th>
                        <th>Metode</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $trx)
                        <tr>
                            <td>{{ $trx->invoice_number }}</td>
                            <td>{{ $trx->sewa->kontrakan->nama }}</td>
                            <td>{{ ucfirst($trx->metode) }}</td>
                            <td>Rp {{ number_format($trx->total_bayar) }}</td>
                            <td>
                                {!! statusBadge($trx->status) !!}
                            </td>
                            <td>{{ $trx->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('user.transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                                <a href="{{ route('user.transaksi.invoice', $trx->id) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-printer"></i> Invoice
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#transaksiTable').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ditemukan data yang cocok",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data tersedia",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Berikutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        });
    </script>
@endpush
