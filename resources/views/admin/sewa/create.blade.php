@extends('admin.layouts.app')

@section('title', 'Tambah Sewa - Admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Tambah Sewa</h1>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('admin.sewa.store') }}" method="POST" id="formSewa">
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

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="user_id" class="form-label">Pilih User</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">-- Pilih User --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="kontrakanSelect" class="form-label">Pilih Kontrakan</label>
                            <select name="kontrakan_id" id="kontrakanSelect" class="form-control" required>
                                <option value="">-- Pilih Kontrakan --</option>
                                @foreach ($kontrakans as $kontrakan)
                                    <option value="{{ $kontrakan->id }}" data-harga="{{ $kontrakan->harga }}">
                                        {{ $kontrakan->nama }} - Rp {{ number_format($kontrakan->harga) }}/bulan
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="jumlahBulanSelect" class="form-label">Jumlah Bulan</label>
                            <select name="jumlah_bulan" id="jumlahBulanSelect" class="form-control" required>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }} bulan</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="diskonDisplay" class="form-label">Diskon</label>
                            <input type="text" id="diskonDisplay" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="totalBayarDisplay" class="form-label">Total Bayar</label>
                            <input type="text" id="totalBayarDisplay" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.sewa.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kontrakanSelect = document.getElementById('kontrakanSelect');
            const jumlahBulanSelect = document.getElementById('jumlahBulanSelect');
            const diskonDisplay = document.getElementById('diskonDisplay');
            const totalBayarDisplay = document.getElementById('totalBayarDisplay');

            function hitung() {
                const selectedOption = kontrakanSelect.options[kontrakanSelect.selectedIndex];
                const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;
                const bulan = parseInt(jumlahBulanSelect.value) || 0;

                let diskon = 0;
                if (bulan >= 3 && bulan <= 5) {
                    diskon = 25000 * bulan;
                } else if (bulan >= 6) {
                    diskon = 50000 * bulan;
                }

                const total = (harga * bulan) - diskon;

                diskonDisplay.value = 'Rp ' + diskon.toLocaleString('id-ID');
                totalBayarDisplay.value = 'Rp ' + total.toLocaleString('id-ID');
            }

            kontrakanSelect.addEventListener('change', hitung);
            jumlahBulanSelect.addEventListener('change', hitung);
        });
    </script>
@endpush
