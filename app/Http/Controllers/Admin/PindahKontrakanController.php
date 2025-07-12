<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kontrakan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\PermintaanPindahKontrakan;
use App\Mail\PindahKontrakanStatusUpdated;

class PindahKontrakanController extends Controller
{
    public function index()
    {
        $permintaan = PermintaanPindahKontrakan::with(['user', 'kontrakanLama', 'kontrakanBaru', 'admin'])->latest()->get();
        return view('admin.pindah.index', compact('permintaan'));
    }

    public function show(PermintaanPindahKontrakan $pindah)
    {
        return view('admin.pindah.show', compact('pindah'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string|max:1000'
        ]);

        $permintaan = PermintaanPindahKontrakan::findOrFail($id);
        $permintaan->update([
            'status' => $request->status,
            'catatan' => $request->catatan,
            'admin_id' => auth('admin')->id(),
        ]);

        if ($request->status == 'disetujui') {
            // Update kontrakan pada sewa
            $sewa = $permintaan->sewa;
            $sewa->kontrakan_id = $permintaan->kontrakan_baru_id;
            $sewa->save();

            // Update status kontrakan
            Kontrakan::where('id', $permintaan->kontrakan_lama_id)->update(['status' => 'tersedia']);
            Kontrakan::where('id', $permintaan->kontrakan_baru_id)->update(['status' => 'disewa']);
        }

        Mail::to($permintaan->user->email)->send(new PindahKontrakanStatusUpdated($permintaan));

        return back()->with('success', 'Permintaan berhasil dikonfirmasi.');
    }

    public function destroy($id)
    {
        $permintaan = PermintaanPindahKontrakan::findOrFail($id);

        // Cegah penghapusan jika status sudah disetujui atau sedang diproses
        if ($permintaan->status === 'disetujui') {
            return back()->with('error', 'Permintaan yang sudah disetujui tidak dapat dihapus.');
        }

        $permintaan->delete();

        return redirect()->route('admin.pindah.index')->with('success', 'Permintaan berhasil dihapus.');
    }
}
