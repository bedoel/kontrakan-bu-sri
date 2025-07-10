<?php

namespace App\Exports;

use App\Models\Pengaduan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PengaduanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Pengaduan::with('user')->latest()->get();
    }

    public function headings(): array
    {
        return ['No', 'Nama User', 'Pesan', 'Status'];
    }

    public function map($p): array
    {
        static $no = 1;
        return [
            $no++,
            $p->user->name,
            $p->pesan,
            ucfirst($p->status),
            statusBadge($p->status),
        ];
    }
}
