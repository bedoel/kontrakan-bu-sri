<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sewa;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\TransaksiUpdated;
use Illuminate\Support\Facades\Mail;


class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('sewa.user', 'sewa.kontrakan')->latest()->paginate(10);
        return view('admin.transaksi.index', compact('transaksis'));
    }

    public function edit(Transaksi $transaksi)
    {
        return view('admin.transaksi.edit', compact('transaksi'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:menunggu_konfirmasi,disetujui,ditolak',
            'pesan' => 'nullable|max:1000',
        ]);

        $transaksi->update([
            'status' => $request->status,
            'pesan' => $request->pesan,
            'admin_id' => auth('admin')->id(),
        ]);

        $sewa = $transaksi->sewa;

        if ($request->status === 'disetujui') {
            $sewa->update(['status' => 'aktif']);
            $sewa->update(['admin_id' => auth('admin')->id()]);

            $sewa->kontrakan->update(['status' => 'disewa']);

            $sewaLama = Sewa::where('user_id', $sewa->user_id)
                ->where('kontrakan_id', $sewa->kontrakan_id)
                ->where('id', '!=', $sewa->id)
                ->where('status', 'aktif')
                ->latest('tanggal_akhir')
                ->first();

            if ($sewaLama) {
                $sewaLama->update(['status' => 'kadaluarsa']);
            }
        } elseif ($request->status === 'ditolak') {
            $sewa->update(['status' => 'ditolak']);
            $sewa->update(['admin_id' => auth('admin')->id()]);

            $sewa->kontrakan->update(['status' => 'tersedia']);
        }

        Mail::to($sewa->user->email)->send(new TransaksiUpdated($transaksi));

        return redirect()->route('admin.transaksi.index')->with('success', 'Transaksi diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {

        if ($transaksi->status === 'menunggu_konfirmasi' || $transaksi->status === 'ditolak') {
            $transaksi->delete();

            return back()->with('success', 'Transaksi berhasil dihapus.');
        }

        return back()->with('error', 'Transaksi tidak dapat dihapus karena sudah disetujui.');
    }
}
