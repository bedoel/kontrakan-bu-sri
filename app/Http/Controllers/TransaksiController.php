<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Sewa;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Admin;

class TransaksiController extends Controller
{

    public function index(Request $request)
    {
        $userId = auth('user')->id();
        $query = Transaksi::with('sewa.kontrakan')
            ->whereHas('sewa', fn($q) => $q->where('user_id', $userId));

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal dari dan sampai
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $transaksis = $query->latest()->get();

        return view('user.transaksi.index', compact('transaksis'));
    }


    public function show(Transaksi $transaksi)
    {
        if ($transaksi->sewa->user_id !== Auth::guard('user')->id()) {
            abort(403, 'Unauthorized access to this transaksi.');
        }

        return view('user.transaksi.show', compact('transaksi'));
    }

    public function invoice(Transaksi $transaksi)
    {
        if ($transaksi->sewa->user_id !== Auth::guard('user')->id()) {
            abort(403, 'Unauthorized access to this transaksi.');
        }


        $pdf = Pdf::loadView('user.transaksi.invoice', compact('transaksi'));
        return $pdf->download('invoice-' . $transaksi->invoice_number . '.pdf');
    }

    public function create(Sewa $sewa)
    {
        $user = auth('user')->user();
        if ($user->id !== $sewa->user_id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $harga = $sewa->kontrakan->harga;
        $durasi = $sewa->tanggal_mulai->diffInMonths($sewa->tanggal_akhir);
        $diskon = $sewa->diskon ?? 0;

        $total = ($harga * $durasi) - $diskon;

        return view('user.transaksi.create', compact('sewa', 'total', 'diskon'));
    }

    public function store(Request $request, Sewa $sewa)
    {
        // Validasi
        $request->validate([
            'metode' => 'required|in:transfer,cash',
            'bukti_transfer' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'metode.required' => 'Metode pembayaran wajib diisi.',
            'bukti_transfer.max' => 'Ukuran file maksimal 2MB.',
            'bukti_transfer.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
        ]);

        if ($request->metode === 'transfer') {
            $request->validate([
                'bukti_transfer' => 'required|mimes:jpg,jpeg,png|max:2048',
            ], [
                'bukti_transfer.required' => 'Bukti transfer wajib diisi.',
                'bukti_transfer.max' => 'Ukuran file maksimal 2MB.',
                'bukti_transfer.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',

            ]);
        }

        // Cegah transaksi ganda
        if ($sewa->transaksi) {
            return back()->with('error', 'Transaksi sudah pernah dilakukan untuk sewa ini.');
        }

        // Ambil nilai total dan diskon dari sewa
        $jumlahBulan = $sewa->tanggal_mulai->diffInMonths($sewa->tanggal_akhir);
        $hargaPerBulan = $sewa->kontrakan->harga;
        $totalBayar = $hargaPerBulan * $jumlahBulan;
        $diskon = $sewa->diskon ?? 0;
        $denda = 0;

        // Upload bukti jika transfer
        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

        // Simpan transaksi
        Transaksi::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(6)),
            'sewa_id' => $sewa->id,
            'metode' => $request->metode,
            'total_bayar' => $totalBayar - $diskon + $denda,
            'diskon' => $diskon,
            'denda' => $denda,
            'bukti_transfer' => $buktiPath,
            'status' => 'menunggu_konfirmasi',
            'catatan' => $request->catatan,
        ]);

        // Update status sewa
        $sewa->status = 'menunggu_konfirmasi';
        $sewa->save();

        $admins = Admin::all();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new AdminNotificationMail(
                'Transaksi Baru Menunggu Konfirmasi',
                'Transaksi baru dari user ' . auth('user')->user()->name,
                route('admin.transaksi.index')
            ));
        }

        return redirect()->route('user.sewa.show', $sewa->id)
            ->with('success', 'Pembayaran berhasil diajukan. Menunggu konfirmasi admin.');
    }
}
