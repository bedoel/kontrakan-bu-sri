<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sewa;
use App\Models\User;
use App\Models\Kontrakan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


    public function index()
    {
        // Statistik utama
        $jumlahUser = User::count();
        $kontrakanTersedia = Kontrakan::where('status', 'tersedia')->count();
        $kontrakanDisewa = Kontrakan::where('status', 'disewa')->count();
        $sewaAktif = Sewa::where('status', 'aktif')->count();
        $transaksiMenunggu = Transaksi::where('status', 'menunggu_konfirmasi')->count();

        // Data transaksi per bulan (chart area)
        $data = Transaksi::selectRaw('MONTH(created_at) as bulan, SUM(total_bayar) as total')
            ->whereYear('created_at', date('Y'))
            ->where('status', 'disetujui')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $mapBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $bulan = [];
        $jumlahPerBulan = [];

        foreach (range(1, 12) as $i) {
            $bulan[] = $mapBulan[$i - 1];
            $item = $data->firstWhere('bulan', $i);
            $jumlahPerBulan[] = $item ? (int) $item->total : 0;
        }

        return view('dashboard.admin', compact(
            'jumlahUser',
            'kontrakanTersedia',
            'kontrakanDisewa',
            'sewaAktif',
            'transaksiMenunggu',
            'bulan',
            'jumlahPerBulan'
        ));
    }
}
