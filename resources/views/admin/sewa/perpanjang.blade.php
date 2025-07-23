@extends('admin.layouts.app')

@section('title', 'Perpanjang Sewa - Admin')

@section('content')
    <h4 class="mb-4">Perpanjangan Sewa</h4>

    <form action="{{ route('admin.sewa.perpanjang.simpan', $sewa->slug) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Kontrakan</label>
            <input type="text" class="form-control" value="{{ $sewa->kontrakan->nama }}" disabled>
        </div>

        <div class="mb-3">
            <label>Harga per Bulan</label>
            <input type="text" class="form-control" value="Rp {{ number_format($sewa->kontrakan->harga) }}" disabled>
        </div>

        <div class="mb-3">
            <label>Jumlah Bulan</label>
            <select name="jumlah_bulan" id="jumlah_bulan" class="form-control" required onchange="updateTotal()">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}">{{ $i }} bulan</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="metode" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="transfer">Transfer</option>
            </select>
        </div>

        <div class="border p-3 rounded mb-4 bg-light">
            <p class="mb-1"><strong>Diskon:</strong> <span id="diskon_text">Rp 0</span></p>
            <p class="mb-1"><strong>Denda:</strong> <span id="denda_text">
                    Rp {{ now()->gt($sewa->tanggal_akhir) ? number_format(25000) : 0 }}</span></p>
            <p class="mb-0"><strong>Total Bayar:</strong> <span id="total_text">Rp
                    {{ number_format($sewa->kontrakan->harga) }}</span></p>
        </div>

        <div class="mt-4">
            <div class="d-grid gap-3 d-md-none">
                {{-- Tampilan MOBILE: Stack dengan jarak --}}


                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <div class="my-2"></div>
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
            </div>

            <div class="d-none d-md-flex justify-content-between gap-3">
                {{-- Tampilan DESKTOP: Horizontal sejajar --}}
                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left-circle"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.sewa.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection

@push('scripts')
    <script>
        const harga = {{ $sewa->kontrakan->harga }};
        const denda = {{ now()->gt($sewa->tanggal_akhir) ? 25000 : 0 }};

        function updateTotal() {
            const bulan = parseInt(document.getElementById('jumlah_bulan').value);
            let diskon = 0;

            if (bulan >= 3 && bulan <= 5) {
                diskon = 25000 * bulan;
            } else if (bulan >= 6) {
                diskon = 50000 * bulan;
            }

            const total = (harga * bulan) - diskon + denda;

            document.getElementById('diskon_text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(diskon);
            document.getElementById('denda_text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(denda);
            document.getElementById('total_text').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }

        // Panggil saat awal
        updateTotal();
    </script>
@endpush
