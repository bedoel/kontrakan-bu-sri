<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sewa;
use App\Models\Kontrakan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermintaanPindahKontrakan;

class SewaController extends Controller
{
    public function index()
    {
        $user = auth('user')->user();

        $sewaAktif = \App\Models\Sewa::with('kontrakan')
            ->where('user_id', $user->id)
            ->whereIn('status', ['aktif', 'menunggu_konfirmasi', 'menunggu_pembayaran'])
            ->get();

        $riwayatSewa = \App\Models\Sewa::with('kontrakan')
            ->where('user_id', $user->id)
            ->whereIn('status', ['selesai', 'kadaluarsa', 'batal', 'ditolak'])
            ->latest('tanggal_akhir')
            ->get();

        $punyaPermintaanMenunggu = \App\Models\PermintaanPindahKontrakan::where('user_id', $user->id)
            ->where('status', 'menunggu')
            ->exists();

        // Ambil semua permintaan yang disetujui
        $permintaanDisetujui = \App\Models\PermintaanPindahKontrakan::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->get()
            ->keyBy('sewa_id'); // agar bisa diakses cepat

        return view('user.sewa.index', compact('sewaAktif', 'riwayatSewa', 'punyaPermintaanMenunggu', 'permintaanDisetujui'));
    }


    // Tampilkan form sewa
    public function create(Kontrakan $kontrakan)
    {
        return view('user.sewa.create', compact('kontrakan'));
    }

    // Proses penyimpanan sewa
    public function store(Request $request)
    {
        $request->validate([
            'kontrakan_id' => 'required|exists:kontrakans,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'jumlah_bulan' => 'required|integer|min:1|max:12',
        ], [
            'kontrakan_id.required' => 'Kontrakan harus dipilih.',
            'kontrakan_id.exists' => 'Kontrakan tidak ditemukan di database.',

            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid.',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh di masa lalu.',

            'jumlah_bulan.required' => 'Jumlah bulan sewa wajib diisi.',
            'jumlah_bulan.integer' => 'Jumlah bulan harus berupa angka.',
            'jumlah_bulan.min' => 'Jumlah bulan minimal 1 bulan.',
            'jumlah_bulan.max' => 'Jumlah bulan maksimal 12 bulan.',
        ]);

        $user = Auth::guard('user')->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // ✅ Cek apakah user sudah memiliki sewa aktif
        $existing = Sewa::where('user_id', $user->id)
            ->whereIn('status', ['menunggu_pembayaran', 'menunggu_konfirmasi', 'aktif'])
            ->first();

        if ($existing) {
            return redirect()->route('user.sewa.index')->with('error', 'Anda sudah memiliki sewa yang sedang berlangsung.');
        }

        $kontrakan = Kontrakan::findOrFail($request->kontrakan_id);
        $tanggalMulai = Carbon::parse($request->tanggal_mulai);
        $jumlahBulan = (int) $request->jumlah_bulan;
        $tanggalAkhir = $tanggalMulai->copy()->addMonthsNoOverflow($jumlahBulan);

        // Hitung diskon
        $diskon = 0;
        if ($jumlahBulan >= 3 && $jumlahBulan <= 5) {
            $diskon = 25000 * $jumlahBulan;
        } elseif ($jumlahBulan >= 6 && $jumlahBulan <= 12) {
            $diskon = 50000 * $jumlahBulan;
        }

        $sewa = Sewa::create([
            'user_id' => $user->id,
            'kontrakan_id' => $kontrakan->id,
            'slug' => Str::uuid(),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_akhir' => $tanggalAkhir,
            'lama_sewa_bulan' => $jumlahBulan,
            'status' => 'menunggu_pembayaran',
            'diskon' => $diskon,
        ]);

        // Ubah status kontrakan jadi "disewa"
        $kontrakan->update([
            'status' => 'disewa',
        ]);

        return redirect()->route('user.sewa.show', $sewa->id)
            ->with('success', 'Pengajuan sewa berhasil, silakan lanjutkan ke pembayaran.');
    }


    // Tampilkan detail sewa
    public function show(Sewa $sewa)
    {
        if ($sewa->user_id !== auth('user')->id()) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        return view('user.sewa.show', compact('sewa'));
    }

    public function batal($id)
    {
        $sewa = Sewa::where('id', $id)
            ->where('user_id', auth('user')->id())
            ->whereIn('status', ['menunggu_pembayaran'])
            ->firstOrFail();

        $sewa->status = 'batal';
        $sewa->save();

        // Update status kontrakan kembali ke tersedia
        $sewa->kontrakan->update(['status' => 'tersedia']);

        return redirect()->route('user.sewa.index')->with('success', 'Sewa berhasil dibatalkan.');
    }

    public function perpanjang(Request $request, Sewa $sewa)
    {
        $user = auth('user')->user();

        if ($sewa->user_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        // Validasi jumlah bulan
        $request->validate([
            'jumlah_bulan' => 'required|integer|min:1|max:12',
        ], [
            'jumlah_bulan.required' => 'Jumlah bulan sewa wajib diisi.',
            'jumlah_bulan.integer' => 'Jumlah bulan harus berupa angka.',
            'jumlah_bulan.min' => 'Jumlah bulan minimal 1 bulan.',
            'jumlah_bulan.max' => 'Jumlah bulan maksimal 12 bulan.',
        ]);

        // Periksa apakah sewa masih dalam status disetujui
        if ($sewa->status !== 'aktif') {
            return back()->with('error', 'Sewa tidak dapat diperpanjang.');
        }

        // Hitung masa sewa baru
        $tanggalMulai = Carbon::parse($sewa->tanggal_akhir)->addDay();
        $jumlahBulan = (int) $request->jumlah_bulan;
        $tanggalAkhir = (clone $tanggalMulai)->addMonths($jumlahBulan)->subDay();

        // Hitung diskon
        $diskon = 0;
        if ($jumlahBulan >= 3 && $jumlahBulan <= 5) {
            $diskon = 25000 * $jumlahBulan;
        } elseif ($jumlahBulan >= 6 && $jumlahBulan <= 12) {
            $diskon = 50000 * $jumlahBulan;
        }

        // Buat entri sewa baru
        $sewaBaru = Sewa::create([
            'user_id' => $user->id,
            'kontrakan_id' => $sewa->kontrakan_id,
            'slug' => Str::uuid(),
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_akhir' => $tanggalAkhir,
            'lama_sewa_bulan' => $jumlahBulan,
            'status' => 'menunggu_pembayaran',
            'diskon' => $diskon,
        ]);

        return redirect()->route('user.sewa.show', $sewaBaru->id)->with('success', 'Pengajuan perpanjangan berhasil.');
    }
}
