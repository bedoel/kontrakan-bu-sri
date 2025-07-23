@extends('admin.layouts.app')

@section('title', 'Detail Sewa - Admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800 text-center text-md-start">Detail Sewa</h1>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-text"></i> Informasi Sewa</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="fw-semibold d-block mb-1">Nama User:</label>
                            <div class="form-control-plaintext text-wrap">{{ $sewa->user->name }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold d-block mb-1">Kontrakan:</label>
                            <div class="form-control-plaintext text-wrap">{{ $sewa->kontrakan->nama }}</div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold d-block mb-1">Tanggal Sewa:</label>
                            <div class="form-control-plaintext text-wrap">
                                {{ \Carbon\Carbon::parse($sewa->tanggal_mulai)->format('d M Y') }} -
                                {{ \Carbon\Carbon::parse($sewa->tanggal_akhir)->format('d M Y') }}
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold d-block mb-1">Status:</label>
                            <div class="form-control-plaintext">{!! statusBadge($sewa->status) !!}</div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-semibold d-block mb-1">Diskon:</label>
                            <div class="form-control-plaintext">
                                Rp {{ number_format($sewa->diskon ?? 0) }}
                            </div>
                        </div>

                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('admin.sewa.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Kembali ke Daftar Sewa
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
