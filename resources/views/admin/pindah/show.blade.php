@extends('admin.layouts.app')

@section('title', 'Detail Permintaan Pindah Kontrakan - Admin')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Detail Permintaan Pindah Kontrakan</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-4">Nama Pengguna</dt>
                <dd class="col-sm-8">{{ $pindah->user->name }}</dd>

                <dt class="col-sm-4">Kontrakan Lama</dt>
                <dd class="col-sm-8">{{ $pindah->kontrakanLama->nama }}</dd>

                <dt class="col-sm-4">Kontrakan Baru</dt>
                <dd class="col-sm-8">{{ $pindah->kontrakanBaru->nama }}</dd>

                <dt class="col-sm-4">Alasan</dt>
                <dd class="col-sm-8">{{ $pindah->alasan }}</dd>

                <dt class="col-sm-4">Status</dt>
                <dd class="col-sm-8">{!! statusBadge($pindah->status) !!}</dd>

                @if ($pindah->admin)
                    <dt class="col-sm-4">Dikonfirmasi Oleh</dt>
                    <dd class="col-sm-8">{{ $pindah->admin->name }}</dd>
                @endif

                @if ($pindah->catatan)
                    <dt class="col-sm-4">Catatan Admin</dt>
                    <dd class="col-sm-8">{{ $pindah->catatan }}</dd>
                @endif
            </dl>

            @if ($pindah->status == 'menunggu')
                <form action="{{ route('admin.pindah.konfirmasi', $pindah->id) }}" method="POST" id="konfirmasiForm">
                    @csrf
                    <div class="form-group mb-2">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="menunggu">-- Pilih Status --</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label>Catatan (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Tuliskan catatan jika perlu..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    <a href="{{ route('admin.pindah.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            @else
                <a href="{{ route('admin.pindah.index') }}" class="btn btn-secondary">Kembali</a>
            @endif
        </div>
    </div>
@endsection
