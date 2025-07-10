<?php

namespace App\Http\Controllers;

use App\Models\Kontrakan;
use App\Models\Testimoni;
use App\Models\Sewa;
use App\Models\User;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function index()
    {
        $kontrakans = Kontrakan::with('foto_kontrakans')
            ->where('status', 'tersedia')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $testimonis = Testimoni::with('user')->latest()->take(5)->get();
        $userHasTestimoni = auth('user')->check()
            ? Testimoni::where('user_id', auth('user')->id())->exists()
            : false;

        // Tambahkan statistik
        $jumlahPenghuni   = User::count();
        $jumlahUnit       = Kontrakan::count();
        $totalSewa        = Sewa::where('status', 'aktif')->count();
        $jumlahTestimoni  = Testimoni::count();

        return view('user.home', compact(
            'kontrakans',
            'testimonis',
            'userHasTestimoni',
            'jumlahPenghuni',
            'jumlahUnit',
            'totalSewa',
            'jumlahTestimoni'
        ));
    }
}
