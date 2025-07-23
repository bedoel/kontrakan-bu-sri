<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ulasan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::with('user')->latest()->get();
        return view('admin.ulasan.index', compact('ulasans'));
    }

    public function show(Ulasan $ulasan)
    {
        // Otomatis menggunakan slug karena getRouteKeyName() di model
        $ulasan->load('user');
        return view('admin.ulasan.show', compact('ulasan'));
    }

    public function destroy(Ulasan $ulasan)
    {
        if ($ulasan->gambar) {
            Storage::disk('public')->delete($ulasan->gambar);
        }

        $ulasan->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
