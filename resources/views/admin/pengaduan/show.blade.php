@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Detail Pengaduan</h1>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-8">
                        <h5 class="mb-3">Informasi Pengaduan</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th>Nama User</th>
                                <td>{{ $pengaduan->user->name }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{!! statusBadge($pengaduan->status) !!}</td>
                            </tr>
                            <tr>
                                <th>Pesan</th>
                                <td>{{ $pengaduan->pesan }}</td>
                            </tr>
                            @if ($pengaduan->gambar)
                                <tr>
                                    <th>Gambar</th>
                                    <td>
                                        <img src="{{ asset('storage/' . $pengaduan->gambar) }}"
                                            class="img-fluid rounded mx-auto d-block" style="max-width: 100%; height: auto;"
                                            alt="Bukti Pengaduan">
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Balasan -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-chat-left-dots"></i> Riwayat Balasan</h6>
            </div>
            <div class="card-body">
                @forelse ($pengaduan->balasan as $balas)
                    <div class="alert {{ $balas->admin ? 'alert-info' : 'alert-secondary' }} shadow-sm">
                        <div class="fw-bold">{{ $balas->admin ? 'Admin' : 'User' }}</div>
                        <p class="mb-0">{{ $balas->pesan }}</p>
                        <small class="text-muted">{{ $balas->created_at->format('d M Y H:i') }}</small>
                    </div>
                @empty
                    <p class="text-muted">Belum ada balasan.</p>
                @endforelse
            </div>
        </div>

        <!-- Form Balasan -->
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h6 class="mb-0 text-white"><i class="bi bi-reply-fill"></i> Balas Pengaduan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaduan.balas', $pengaduan->id) }}" method="POST">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="pesan" class="form-label">Pesan Balasan</label>
                        <textarea name="pesan" id="pesan" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-success">
                            <i class="bi bi-send"></i> Kirim Balasan
                        </button>
                        <a href="{{ route('admin.pengaduan.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
