<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Transaksi::with(['sewa.kontrakan', 'sewa.user'])->latest()->get();
    }

    public function headings(): array
    {
        return ['No', 'Invoice', 'Nama Penyewa', 'Kontrakan', 'Total Bayar', 'Metode', 'Status'];
    }

    public function map($trx): array
    {
        static $no = 1;
        return [
            $no++,
            $trx->invoice_number,
            $trx->sewa->user->name ?? '-',
            $trx->sewa->kontrakan->nama ?? '-',
            'Rp ' . number_format($trx->total_bayar),
            ucfirst($trx->metode),
            ucfirst($trx->status),
        ];
    }
}
