@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h5 mb-3 text-gray-800 text-center text-md-start">Detail Pengaduan</h1>

        <!-- Info Pengaduan -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-12 col-md-8">
                        <h5 class="mb-3 fs-6">Informasi Pengaduan</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <th class="fs-6">Nama User</th>
                                    <td class="fs-6">{{ $pengaduan->user->name }}</td>
                                </tr>
                                <tr>
                                    <th class="fs-6">Status</th>
                                    <td class="fs-6">{!! statusBadge($pengaduan->status) !!}</td>
                                </tr>
                                <tr>
                                    <th class="fs-6">Pesan</th>
                                    <td class="fs-6">{{ $pengaduan->pesan }}</td>
                                </tr>
                                @if ($pengaduan->gambar)
                                    <tr>
                                        <th class="fs-6">Gambar</th>
                                        <td>
                                            <img src="{{ asset('storage/' . $pengaduan->gambar) }}"
                                                class="img-fluid rounded mx-auto d-block mt-2" style="max-width: 100%;"
                                                alt="Bukti Pengaduan">
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Balasan -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 fs-6"><i class="bi bi-chat-left-dots"></i> Riwayat Balasan</h6>
            </div>
            <div class="card-body">
                @forelse ($pengaduan->balasan as $balas)
                    <div class="alert {{ $balas->admin ? 'alert-info' : 'alert-secondary' }} shadow-sm">
                        <div class="fw-bold small">{{ $balas->admin ? 'Admin' : 'User' }}</div>
                        <p class="mb-1 small">{{ $balas->pesan }}</p>
                        <small class="text-muted">{{ $balas->created_at->format('d M Y H:i') }}</small>
                    </div>
                @empty
                    <p class="text-muted small">Belum ada balasan.</p>
                @endforelse
            </div>
        </div>

        <!-- Form Balas -->
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h6 class="mb-0 text-white fs-6"><i class="bi bi-reply-fill"></i> Balas Pengaduan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaduan.balas', $pengaduan->id) }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="pesan" class="form-label small">Pesan Balasan</label>
                        <textarea name="pesan" id="pesan" class="form-control form-control-sm" rows="4" required></textarea>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-success btn-sm">
                            <i class="bi bi-send"></i> Kirim Balasan
                        </button>
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
