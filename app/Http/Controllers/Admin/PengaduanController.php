<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use App\Models\BalasanPengaduan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserPengaduanStatusUpdated;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $pengaduans = Pengaduan::with('user', 'balasan')->latest()->get();
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load('user', 'balasan.admin', 'balasan.user');
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function balas(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'pesan' => 'required|string|max:255',
        ]);

        // Simpan balasan
        $balasan = BalasanPengaduan::create([
            'pengaduan_id' => $pengaduan->id,
            'admin_id' => auth('admin')->id(),
            'pesan' => $request->pesan,
        ]);

        Mail::to($pengaduan->user->email)->send(new \App\Mail\UserBalasanPengaduan($balasan));

        return back()->with('success', 'Balasan berhasil dikirim.');
    }

    public function ubahStatus(Request $request, Pengaduan $pengaduan)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
        ]);

        $pengaduan->update([
            'status' => $request->status,
        ]);

        Mail::to($pengaduan->user->email)->send(new UserPengaduanStatusUpdated($pengaduan));

        return back()->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        // Hapus gambar jika ada
        if ($pengaduan->gambar) {
            Storage::disk('public')->delete($pengaduan->gambar);
        }

        // Hapus semua balasan terlebih dahulu
        $pengaduan->balasan()->delete();

        // Hapus pengaduan
        $pengaduan->delete();

        return back()->with('success', 'Pengaduan berhasil dihapus.');
    }
}
