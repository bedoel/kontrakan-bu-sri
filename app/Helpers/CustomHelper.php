<?php

if (!function_exists('statusBadge')) {
    function statusBadge($status)
    {
        $status = strtolower($status);
        return match ($status) {
            'menunggu_pembayaran' => '<span class="badge bg-warning text-dark">Menunggu Pembayaran</span>',
            'menunggu_konfirmasi' => '<span class="badge bg-primary text-white">Menunggu Konfirmasi</span>',
            'diproses' => '<span class="badge bg-primary text-white">Diproses</span>',
            'aktif' => '<span class="badge bg-success text-white">Aktif</span>',
            'tersedia' => '<span class="badge bg-success text-white">Tersedia</span>',
            'disetujui' => '<span class="badge bg-success text-white">Disetujui</span>',
            'selesai' => '<span class="badge bg-secondary text-white">Selesai</span>',
            'ditolak' => '<span class="badge bg-danger text-white">Ditolak</span>',
            'disewa' => '<span class="badge bg-danger text-white">Disewa</span>',
            'kadaluarsa' => '<span class="badge bg-dark text-white">Kadaluarsa</span>',
            'batal' => '<span class="badge bg-danger text-white">Batal</span>',
            'menunggu' => '<span class="badge bg-warning text-dark">Menunggu</span>',
            default => '<span class="badge bg-light text-dark">' . ucfirst($status) . '</span>',
        };
    }
}
