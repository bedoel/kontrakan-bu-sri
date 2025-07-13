<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use App\Models\Admin;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\AdminNewPengaduan;
use App\Models\BalasanPengaduan;
use App\Mail\AdminBalasanPengaduan;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PengaduanController extends Controller
{
    private function cekSewaAktif()
    {
        $user = auth('user')->user();
        $sewaAktif = Sewa::where('user_id', $user->id)->where('status', 'aktif')->first();

        if (!$sewaAktif) {
            return redirect()->back()->with('swal', [
                'icon' => 'error',
                'title' => 'Akses Ditolak!',
                'text' => 'Anda tidak memiliki sewa aktif untuk mengakses fitur ini.',
                'redirect' => route('user.home')
            ]);
        }

        return $sewaAktif;
    }



    public function index()
    {
        $sewa = $this->cekSewaAktif();
        $pengaduans = Pengaduan::with('balasan')->where('user_id', auth('user')->id())->latest()->get();
        return view('user.pengaduan.index', compact('pengaduans'));
    }

    public function create()
    {
        $sewa = $this->cekSewaAktif();
        return view('user.pengaduan.create', compact('sewa'));
    }

    public function store(Request $request)
    {
        $sewa = $this->cekSewaAktif();
        $request->validate([
            'pesan' => 'required|string|max:2000',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'pesan.required' => 'Pesan wajib diisi.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
        ]);

        $gambar = $request->hasFile('gambar')
            ? $request->file('gambar')->store('pengaduan', 'public')
            : null;

        $pengaduan = Pengaduan::create([
            'user_id' => auth('user')->id(),
            'slug' => Str::uuid(),
            'pesan' => $request->pesan,
            'status' => 'menunggu',
            'gambar' => $gambar,
        ]);

        $admins = Admin::all();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new AdminNotificationMail(
                'Pengaduan Baru Masuk',
                'Ada pengaduan baru dari user ' . auth('user')->user()->name,
                route('admin.pengaduan.index')
            ));
        }

        return redirect()->route('user.pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    public function show(Pengaduan $pengaduan)
    {
        $sewa = $this->cekSewaAktif();
        abort_if($pengaduan->user_id !== auth('user')->id(), 403);
        $pengaduan->load('balasan.admin', 'balasan.user');
        return view('user.pengaduan.show', compact('pengaduan'));
    }

    public function balas(Request $request, Pengaduan $pengaduan)
    {

        $sewa = $this->cekSewaAktif();
        $request->validate([
            'pesan' => 'required|string|max:1000',
        ]);

        if ($pengaduan->user_id !== auth('user')->id()) {
            abort(403, 'Anda tidak berhak membalas pengaduan ini.');
        }

        $balasan = BalasanPengaduan::create([
            'pengaduan_id' => $pengaduan->id,
            'user_id' => auth('user')->id(),
            'admin_id' => null,
            'pesan' => $request->pesan,
        ]);

        $admins = Admin::all();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new AdminBalasanPengaduan($balasan));
        }


        return redirect()->back()->with('success', 'Balasan berhasil dikirim.');
    }
}
