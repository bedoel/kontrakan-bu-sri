<?php

namespace App\Exports;

use App\Models\PermintaanPindahKontrakan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PindahKontrakanExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return PermintaanPindahKontrakan::with(['user', 'kontrakanLama', 'kontrakanBaru'])->latest()->get();
    }

    public function headings(): array
    {
        return ['No', 'User', 'Dari', 'Ke', 'Alasan', 'Status'];
    }

    public function map($p): array
    {
        static $no = 1;
        return [
            $no++,
            $p->user->name,
            $p->kontrakanLama->nama,
            $p->kontrakanBaru->nama,
            $p->alasan,
            ucfirst($p->status),
        ];
    }
}
