@extends('admin.layouts.app')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Edit Sewa</h1>

    <form action="{{ route('admin.sewa.update', $sewa->id) }}" method="POST">
        @csrf
        @method('PUT')

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $sewa->user_id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Kontrakan</label>
            <select name="kontrakan_id" class="form-control" id="kontrakanSelect" required>
                @foreach ($kontrakans as $kontrakan)
                    <option value="{{ $kontrakan->id }}" data-harga="{{ $kontrakan->harga }}"
                        {{ $kontrakan->id == $sewa->kontrakan_id ? 'selected' : '' }}>
                        {{ $kontrakan->nama }} - Rp {{ number_format($kontrakan->harga) }}/bulan
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control"
                value="{{ \Carbon\Carbon::parse($sewa->tanggal_mulai)->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label>Tanggal Akhir</label>
            <input type="date" name="tanggal_akhir" class="form-control"
                value="{{ \Carbon\Carbon::parse($sewa->tanggal_akhir)->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="menunggu_konfirmasi" {{ $sewa->status == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu
                </option>
                <option value="menunggu_pembayaran" {{ $sewa->status == 'menunggu_pembayaran' ? 'selected' : '' }}>
                    Menunggu Pembayaran</option>
                <option value="aktif" {{ $sewa->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="selesai" {{ $sewa->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ $sewa->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="kadaluarsa" {{ $sewa->status == 'kadaluarsa' ? 'selected' : '' }}>kadaluarsa</option>
                <option value="batal" {{ $sewa->status == 'batal' ? 'selected' : '' }}>Batal</option>
            </select>
        </div>

        <div class="form-group">
            <label>Estimasi Diskon</label>
            <input type="text" id="diskonDisplay" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label>Estimasi Total Bayar</label>
            <input type="text" id="totalBayarDisplay" class="form-control" readonly>
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.sewa.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kontrakanSelect = document.getElementById('kontrakanSelect');
            const tanggalMulai = document.querySelector('[name="tanggal_mulai"]');
            const tanggalAkhir = document.querySelector('[name="tanggal_akhir"]');
            const diskonDisplay = document.getElementById('diskonDisplay');
            const totalBayarDisplay = document.getElementById('totalBayarDisplay');

            function hitung() {
                const selectedOption = kontrakanSelect.options[kontrakanSelect.selectedIndex];
                const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;

                const start = new Date(tanggalMulai.value);
                const end = new Date(tanggalAkhir.value);
                const bulan = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth());

                let diskon = 0;
                if (bulan >= 3 && bulan <= 5) {
                    diskon = 25000 * bulan;
                } else if (bulan >= 6) {
                    diskon = 50000 * bulan;
                }

                const total = (harga * bulan) - diskon;

                diskonDisplay.value = 'Rp ' + diskon.toLocaleString();
                totalBayarDisplay.value = 'Rp ' + total.toLocaleString();
            }

            kontrakanSelect.addEventListener('change', hitung);
            tanggalMulai.addEventListener('change', hitung);
            tanggalAkhir.addEventListener('change', hitung);

            // Hitung awal saat halaman dibuka
            hitung();
        });
    </script>
@endpush
