<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sewa;
use App\Exports\SewaExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PengaduanExport;
use App\Exports\TransaksiExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PindahKontrakanExport;

class LaporanController extends Controller
{
    public function exportSewaPdf()
    {
        $data = Sewa::with(['user', 'kontrakan', 'admin'])->latest()->get();
        $pdf = Pdf::loadView('admin.laporan.sewa', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan_sewa.pdf');
    }

    public function exportSewaExcel()
    {
        return Excel::download(new SewaExport, 'laporan_sewa.xlsx');
    }

    public function exportTransaksiExcel()
    {
        return Excel::download(new TransaksiExport, 'transaksi.xlsx');
    }

    public function exportTransaksiPdf()
    {
        $transaksis = \App\Models\Transaksi::with('sewa.kontrakan', 'sewa.user')->get();
        $pdf = PDF::loadView('admin.laporan.transaksi_pdf', compact('transaksis'));
        return $pdf->download('transaksi.pdf');
    }

    public function exportPengaduanExcel()
    {
        return Excel::download(new PengaduanExport, 'pengaduan.xlsx');
    }

    public function exportPengaduanPdf()
    {
        $pengaduans = \App\Models\Pengaduan::with('user')->get();
        $pdf = PDF::loadView('admin.laporan.pengaduan_pdf', compact('pengaduans'));
        return $pdf->download('pengaduan.pdf');
    }

    public function exportPindahExcel()
    {
        return Excel::download(new PindahKontrakanExport, 'pindah_kontrakan.xlsx');
    }

    public function exportPindahPdf()
    {
        $pindahs = \App\Models\PermintaanPindahKontrakan::with(['user', 'kontrakanLama', 'kontrakanBaru'])->get();
        $pdf = PDF::loadView('admin.laporan.pindah_pdf', compact('pindahs'));
        return $pdf->download('pindah_kontrakan.pdf');
    }
}
