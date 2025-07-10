<?php

namespace App\Exports;

use App\Models\Sewa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SewaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Sewa::with(['user', 'kontrakan', 'admin'])->latest()->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Penyewa',
            'Kontrakan',
            'Tanggal Mulai',
            'Tanggal Akhir',
            'Status',
            'Diskon',
            'Admin',
        ];
    }

    public function map($sewa): array
    {
        static $no = 1;

        return [
            $no++,
            $sewa->user->name,
            $sewa->kontrakan->nama,
            $sewa->tanggal_mulai->format('d-m-Y'),
            $sewa->tanggal_akhir->format('d-m-Y'),
            ucfirst($sewa->status),
            $sewa->diskon ? 'Rp ' . number_format($sewa->diskon) : '-',
            $sewa->admin->name ?? '-',
        ];
    }
}
