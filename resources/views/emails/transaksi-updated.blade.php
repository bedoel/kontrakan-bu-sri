<h3>Halo, {{ $transaksi->sewa->user->name }}</h3>

@if ($transaksi->status == 'disetujui')
    <p>Selamat! Transaksi Anda dengan invoice <strong>{{ $transaksi->invoice_number }}</strong> telah
        <strong>disetujui</strong>.
    </p>
    <p>Anda telah resmi menyewa kontrakan <strong>{{ $transaksi->sewa->kontrakan->nama }}</strong>.</p>
    <p>
        Masa sewa Anda dimulai pada
        <strong>{{ $transaksi->sewa->tanggal_mulai->translatedFormat('d M Y') }}</strong>
        dan berakhir pada
        <strong>{{ $transaksi->sewa->tanggal_akhir->translatedFormat('d M Y') }}</strong>.
    </p>
@elseif ($transaksi->status == 'ditolak')
    <p>Mohon maaf, transaksi Anda dengan invoice <strong>{{ $transaksi->invoice_number }}</strong> telah
        <strong>ditolak</strong> oleh admin.
    </p>
    <p>Silakan hubungi admin atau coba lakukan transaksi ulang.</p>
@else
    <p>Status transaksi Anda saat ini: <strong>{!! statusBadge($transaksi->status) !!}</strong>.</p>
@endif

{{-- Tampilkan catatan admin di semua kondisi --}}
@if ($transaksi->catatan)
    <div class="alert alert-info mt-3">
        <h5 class="mb-2"><i class="bi bi-chat-dots me-2"></i>Pesan dari Admin</h5>
        <p class="mb-0">{{ $transaksi->catatan }}</p>
    </div>
@endif

<hr>

<ul>
    <li><strong>Total Bayar:</strong> Rp {{ number_format($transaksi->total_bayar) }}</li>
    <li><strong>Metode Pembayaran:</strong> {{ ucfirst($transaksi->metode) }}</li>
</ul>

<p>Terima kasih telah menggunakan layanan kontrakan Bu Sri.</p>
