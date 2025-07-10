<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use App\Models\Kontrakan;
use App\Mail\PindahKontrakanRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PermintaanPindahKontrakan;

class PindahKontrakanController extends Controller
{
    public function index()
    {
        $user = auth('user')->user();
        $permintaan = $user->permintaanPindah()->latest()->with(['kontrakanBaru', 'kontrakanLama'])->get();

        return view('user.pindah.index', compact('permintaan'));
    }

    public function create()
    {
        $user = auth('user')->user();
        $sewa = Sewa::where('user_id', $user->id)->where('status', 'aktif')->firstOrFail();
        $kontrakans = Kontrakan::where('status', 'tersedia')->get();

        return view('user.pindah.create', compact('kontrakans', 'sewa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kontrakan_baru_id' => 'required|exists:kontrakans,id',
            'alasan' => 'required|string|max:1000'
        ], [
            'kontrakan_baru_id' => 'Kontrakan wajib diisi.',
            'alasan' => 'Alasan wajib diisi.',
        ]);

        $user = auth('user')->user();

        // Cek apakah user masih punya permintaan pindah yang statusnya "menunggu"
        $existing = PermintaanPindahKontrakan::where('user_id', $user->id)
            ->where('status', 'menunggu')
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'Anda sudah memiliki permintaan pindah yang sedang menunggu konfirmasi.');
        }

        $sewa = Sewa::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->firstOrFail();

        $permintaan = PermintaanPindahKontrakan::create([
            'user_id' => $user->id,
            'sewa_id' => $sewa->id,
            'kontrakan_lama_id' => $sewa->kontrakan_id,
            'kontrakan_baru_id' => $request->kontrakan_baru_id,
            'alasan' => $request->alasan,
            'status' => 'menunggu',
            'slug' => Str::uuid(),
        ]);

        // Kirim email ke semua admin
        $adminEmails = \App\Models\Admin::pluck('email')->toArray();

        foreach ($adminEmails as $email) {
            Mail::to($email)->send(new PindahKontrakanRequest($permintaan));
        }

        return redirect()->route('user.sewa.index')->with('success', 'Pengajuan pindah berhasil dikirim.');
    }
}
