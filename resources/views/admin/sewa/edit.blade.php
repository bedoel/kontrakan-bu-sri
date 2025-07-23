@extends('admin.layouts.app')

@section('title', 'Edit Sewa - Admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 text-center text-md-start">Edit Sewa</h1>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.sewa.update', $sewa->slug) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih User</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $sewa->user_id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kontrakanSelect" class="form-label">Pilih Kontrakan</label>
                        <select name="kontrakan_id" id="kontrakanSelect" class="form-control" required>
                            @foreach ($kontrakans as $kontrakan)
                                <option value="{{ $kontrakan->id }}" data-harga="{{ $kontrakan->harga }}"
                                    {{ $kontrakan->id == $sewa->kontrakan_id ? 'selected' : '' }}>
                                    {{ $kontrakan->nama }} - Rp {{ number_format($kontrakan->harga) }}/bulan
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                                value="{{ \Carbon\Carbon::parse($sewa->tanggal_mulai)->format('Y-m-d') }}" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                                value="{{ \Carbon\Carbon::parse($sewa->tanggal_akhir)->format('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Sewa</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="menunggu_konfirmasi"
                                {{ $sewa->status == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="menunggu_pembayaran"
                                {{ $sewa->status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="aktif" {{ $sewa->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ $sewa->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ $sewa->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            <option value="kadaluarsa" {{ $sewa->status == 'kadaluarsa' ? 'selected' : '' }}>Kadaluarsa
                            </option>
                            <option value="batal" {{ $sewa->status == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <div class="d-grid gap-3 d-md-none">
                            {{-- Tampilan MOBILE: Stack dengan jarak --}}
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <div class="my-2"></div>
                            <a href="{{ route('admin.sewa.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                        </div>

                        <div class="d-none d-md-flex justify-content-between gap-3">
                            {{-- Tampilan DESKTOP: Horizontal sejajar --}}
                            <a href="{{ route('admin.sewa.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
