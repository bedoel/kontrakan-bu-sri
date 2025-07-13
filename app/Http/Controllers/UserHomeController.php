<?php

namespace App\Http\Controllers;

use App\Models\Kontrakan;
use App\Models\Ulasan;
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

        $ulasans = Ulasan::with('user')->latest()->take(5)->get();
        $userHasUlasan = auth('user')->check()
            ? Ulasan::where('user_id', auth('user')->id())->exists()
            : false;

        // Tambahkan statistik
        $jumlahPenghuni   = User::count();
        $jumlahUnit       = Kontrakan::count();
        $totalSewa        = Sewa::where('status', 'aktif')->count();
        $jumlahUlasan  = Ulasan::count();

        return view('user.home', compact(
            'kontrakans',
            'ulasans',
            'userHasUlasan',
            'jumlahPenghuni',
            'jumlahUnit',
            'totalSewa',
            'jumlahUlasan'
        ));
    }
}
