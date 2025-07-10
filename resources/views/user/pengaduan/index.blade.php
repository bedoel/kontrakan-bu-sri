@extends('user.layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
        style="background-image: url('{{ asset('front/assets/img/hero-2.jpg') }}');">
        <div class="container position-relative">
            <h1>Pengaduan Saya</h1>
            <p>Lihat dan ajukan keluhan atau laporan terkait kontrakan</p>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li class="current">Pengaduan</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="starter-section section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Riwayat Pengaduan</h2>
            <p>Berikut adalah daftar pengaduan yang pernah Anda ajukan</p>
        </div>

        <div class="container" data-aos="fade-up">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('user.pengaduan.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Pengaduan
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle datatable" id="pengaduanTable">
                    <thead class="table-light">
                        <tr>
                            <th>Pesan</th>
                            <th>Status</th>
                            <th>Balasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduans as $p)
                            <tr>
                                <td>{{ Str::limit($p->pesan, 50) }}</td>
                                <td>
                                    {!! statusBadge($p->status) !!}
                                </td>
                                <td>
                                    {{ $p->balasan->count() > 0 ? $p->balasan->count() . ' Balasan' : 'Belum ada balasan' }}
                                </td>
                                <td>
                                    <a href="{{ route('user.pengaduan.show', $p->id) }}"
                                        class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#pengaduanTable').DataTable({
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
