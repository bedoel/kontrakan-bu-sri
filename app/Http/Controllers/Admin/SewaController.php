<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sewa;
use App\Models\User;
use App\Models\Kontrakan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SewaController extends Controller
{
    public function index()
    {
        $sewas = Sewa::with(['user', 'kontrakan'])->latest()->get();
        return view('admin.sewa.index', compact('sewas'));
    }

    public function create()
    {
        $users = User::all();
        $kontrakans = Kontrakan::where('status', 'tersedia')->get();
        return view('admin.sewa.create', compact('users', 'kontrakans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kontrakan_id' => 'required|exists:kontrakans,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'jumlah_bulan' => 'required|integer|min:1|max:12',
        ], [
            'user_id.required' => 'Pengguna wajib dipilih.',
            'user_id.exists' => 'Pengguna tidak ditemukan.',

            'kontrakan_id.required' => 'Kontrakan wajib dipilih.',
            'kontrakan_id.exists' => 'Kontrakan tidak valid.',

            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Tanggal mulai harus berupa tanggal yang valid.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',

            'jumlah_bulan.required' => 'Jumlah bulan wajib diisi.',
            'jumlah_bulan.integer' => 'Jumlah bulan harus berupa angka.',
            'jumlah_bulan.min' => 'Minimal lama sewa adalah 1 bulan.',
            'jumlah_bulan.max' => 'Maksimal lama sewa adalah 12 bulan.',
        ]);


        $kontrakan = Kontrakan::findOrFail($request->kontrakan_id);
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $jumlahBulan = (int) $request->jumlah_bulan;
        $tanggalAkhir = $tanggalMulai->copy()->addMonthsNoOverflow($jumlahBulan);

        $diskon = 0;
        if ($jumlahBulan >= 3 && $jumlahBulan <= 5) {
            $diskon = 25000 * $jumlahBulan;
        } elseif ($jumlahBulan >= 6 && $jumlahBulan <= 12) {
            $diskon = 50000 * $jumlahBulan;
        }

        $sewa = Sewa::create([
            'user_id' => $request->user_id,
            'kontrakan_id' => $kontrakan->id,
            'slug' => Str::uuid(),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_akhir' => $tanggalAkhir,
            'lama_sewa_bulan' => $jumlahBulan,
            'status' => 'aktif',
            'diskon' => $diskon,
            'admin_id' => auth('admin')->id()
        ]);

        $kontrakan->update(['status' => 'disewa']);

        $total = ($kontrakan->harga * $jumlahBulan) - $diskon;

        Transaksi::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(6)),
            'sewa_id' => $sewa->id,
            'metode' => 'cash',
            'total_bayar' => $total,
            'diskon' => $diskon,
            'denda' => 0,
            'status' => 'disetujui',
            'catatan' => 'Transaksi dibuat oleh admin',
            'admin_id' => auth('admin')->id()
        ]);

        return redirect()->route('admin.sewa.index')->with('success', 'Data sewa berhasil disimpan.');
    }

    public function show(Sewa $sewa)
    {
        $sewa->load('user', 'kontrakan', 'transaksi');
        return view('admin.sewa.show', compact('sewa'));
    }

    public function edit(Sewa $sewa)
    {
        $users = User::all();
        $kontrakans = Kontrakan::all();
        return view('admin.sewa.edit', compact('sewa', 'users', 'kontrakans'));
    }

    public function update(Request $request, Sewa $sewa)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kontrakan_id' => 'required|exists:kontrakans,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after:tanggal_mulai',
            'status' => 'required|in:menunggu_konfirmasi,menunggu_pembayaran,aktif,selesai,ditolak,kadaluarsa,batal',
        ], [
            'user_id.required' => 'Pengguna wajib dipilih.',
            'user_id.exists' => 'Pengguna tidak ditemukan.',

            'kontrakan_id.required' => 'Kontrakan wajib dipilih.',
            'kontrakan_id.exists' => 'Kontrakan tidak valid.',

            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Tanggal mulai harus berupa tanggal yang valid.',

            'tanggal_akhir.required' => 'Tanggal akhir wajib diisi.',
            'tanggal_akhir.date' => 'Tanggal akhir harus berupa tanggal yang valid.',
            'tanggal_akhir.after' => 'Tanggal akhir harus setelah tanggal mulai.',

            'status.required' => 'Status sewa wajib diisi.',
            'status.in' => 'Status tidak valid.',
        ]);


        $sewa->update([
            'user_id' => $request->user_id,
            'kontrakan_id' => $request->kontrakan_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'status' => $request->status,
            'admin_id' => auth('admin')->id(),
        ]);

        return redirect()->route('admin.sewa.index')->with('success', 'Data sewa berhasil diperbarui.');
    }

    public function destroy(Sewa $sewa)
    {
        if ($sewa->transaksi) {
            $sewa->transaksi->delete();
        }

        if ($sewa->kontrakan) {
            $sewa->kontrakan->update(['status' => 'tersedia']);
        }

        $sewa->delete();

        return redirect()->route('admin.sewa.index')->with('success', 'Data sewa berhasil dihapus.');
    }

    public function formPerpanjang(Sewa $sewa)
    {
        return view('admin.sewa.perpanjang', compact('sewa'));
    }

    public function simpanPerpanjang(Request $request, Sewa $sewa)
    {
        $request->validate([
            'jumlah_bulan' => 'required|integer|min:1|max:12',
            'metode' => 'required|in:cash,transfer',
        ]);

        $jumlahBulan = (int) $request->jumlah_bulan;
        $metode = $request->metode;

        // Hitung tanggal mulai dan akhir sewa baru
        $tanggalMulai = Carbon::parse($sewa->tanggal_akhir)->addDay();
        $tanggalAkhir = (clone $tanggalMulai)->addMonths($jumlahBulan)->subDay();

        // Hitung harga dan diskon
        $hargaPerBulan = $sewa->kontrakan->harga;
        $totalBayar = $hargaPerBulan * $jumlahBulan;
        $diskon = 0;

        if ($jumlahBulan >= 3 && $jumlahBulan <= 5) {
            $diskon = 25000 * $jumlahBulan;
        } elseif ($jumlahBulan >= 6) {
            $diskon = 50000 * $jumlahBulan;
        }

        $sewaBaru = Sewa::create([
            'user_id'           => $sewa->user_id,
            'slug'              => Str::uuid(),
            'kontrakan_id'      => $sewa->kontrakan_id,
            'tanggal_mulai'     => $tanggalMulai,
            'tanggal_akhir'     => $tanggalAkhir,
            'lama_sewa_bulan'   => $jumlahBulan,
            'status'            => $metode === 'cash' ? 'aktif' : 'menunggu_pembayaran',
            'admin_id' => auth('admin')->id(),
        ]);

        if ($metode === 'cash') {
            Transaksi::create([
                'invoice_number'    => 'INV-' . strtoupper(Str::random(8)),
                'sewa_id'           => $sewaBaru->id,
                'metode'            => 'cash',
                'total_bayar'       => $totalBayar - $diskon,
                'diskon'            => $diskon,
                'denda'             => 0,
                'status'            => 'disetujui',
                'admin_id' => auth('admin')->id(),
            ]);

            $sewa->update(['status' => 'kadaluarsa']);
        }

        return redirect()
            ->route('admin.sewa.index')
            ->with('success', 'Perpanjangan sewa berhasil disimpan.');
    }
}
