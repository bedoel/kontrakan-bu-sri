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

if (!function_exists('statusBadgePdf')) {
    function statusBadgePdf($status)
    {
        $status = strtolower($status);
        return match ($status) {
            'menunggu_pembayaran' => '<span style="background:#ffc107; color:#000; padding:2px 6px; border-radius:4px;">Menunggu Pembayaran</span>',
            'menunggu_konfirmasi' => '<span style="background:#0d6efd; color:#fff; padding:2px 6px; border-radius:4px;">Menunggu Konfirmasi</span>',
            'diproses' => '<span style="background:#0d6efd; color:#fff; padding:2px 6px; border-radius:4px;">Diproses</span>',
            'aktif' => '<span style="background:#198754; color:#fff; padding:2px 6px; border-radius:4px;">Aktif</span>',
            'tersedia' => '<span style="background:#198754; color:#fff; padding:2px 6px; border-radius:4px;">Tersedia</span>',
            'disetujui' => '<span style="background:#198754; color:#fff; padding:2px 6px; border-radius:4px;">Disetujui</span>',
            'selesai' => '<span style="background:#6c757d; color:#fff; padding:2px 6px; border-radius:4px;">Selesai</span>',
            'ditolak' => '<span style="background:#dc3545; color:#fff; padding:2px 6px; border-radius:4px;">Ditolak</span>',
            'disewa' => '<span style="background:#dc3545; color:#fff; padding:2px 6px; border-radius:4px;">Disewa</span>',
            'kadaluarsa' => '<span style="background:#343a40; color:#fff; padding:2px 6px; border-radius:4px;">Kadaluarsa</span>',
            'batal' => '<span style="background:#dc3545; color:#fff; padding:2px 6px; border-radius:4px;">Batal</span>',
            'menunggu' => '<span style="background:#ffc107; color:#000; padding:2px 6px; border-radius:4px;">Menunggu</span>',
            default => '<span style="background:#adb5bd; color:#000; padding:2px 6px; border-radius:4px;">' . ucfirst($status) . '</span>',
        };
    }
}
