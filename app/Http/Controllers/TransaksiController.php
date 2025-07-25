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

        $transaksis = $query->latest()->get();

        return view('user.transaksi.index', compact('transaksis'));
    }


    public function show($invoice_number)
    {
        $transaksi = Transaksi::with('sewa')
            ->where('invoice_number', $invoice_number)
            ->firstOrFail();

        if ($transaksi->sewa->user_id !== auth('user')->id()) {
            return redirect()->route('user.transaksi.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        return view('user.transaksi.show', compact('transaksi'));
    }

    public function invoice($invoice_number)
    {
        $transaksi = Transaksi::with('sewa')
            ->where('invoice_number', $invoice_number)
            ->firstOrFail();

        if ($transaksi->sewa->user_id !== auth('user')->id()) {
            return redirect()->route('user.transaksi.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        $pdf = PDF::loadView('user.transaksi.invoice', compact('transaksi'));
        return $pdf->download('invoice-' . $transaksi->invoice_number . '.pdf');
    }


    public function create(Sewa $sewa)
    {
        $user = auth('user')->user();
        if ($sewa->user_id !== auth('user')->id()) {
            return redirect()->route('user.transaksi.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        if ($user->id !== $sewa->user_id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $harga = $sewa->kontrakan->harga;
        $durasi = $sewa->lama_sewa_bulan;
        $diskon = $sewa->diskon ?? 0;
        $denda = $sewa->denda ?? 0;

        $total = ($harga * $durasi) - $diskon + $denda;

        return view('user.transaksi.create', compact('sewa', 'total', 'diskon'));
    }

    public function store(Request $request, Sewa $sewa)
    {
        $request->validate([
            'metode' => 'required|in:transfer,cash',
            'bukti_transfer' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'catatan' => 'nullable|string|max:500',
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

        if ($sewa->user_id !== auth('user')->id()) {
            return redirect()->route('user.transaksi.index')->with('error', 'Anda tidak memiliki akses ke data ini.');
        }

        // Cegah transaksi ganda
        if ($sewa->transaksi) {
            return back()->with('error', 'Transaksi sudah pernah dilakukan untuk sewa ini.');
        }

        // Ambil nilai total dan diskon dari sewa
        $jumlahBulan = $sewa->lama_sewa_bulan;
        $hargaPerBulan = $sewa->kontrakan->harga;
        $totalBayar = $hargaPerBulan * $jumlahBulan;
        $diskon = $sewa->diskon ?? 0;
        $denda = $sewa->denda ?? 0;

        // Upload bukti jika transfer
        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
        }

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

        return redirect()->route('user.sewa.show', $sewa->slug)
            ->with('success', 'Pembayaran berhasil diajukan. Menunggu konfirmasi admin.');
    }
}
