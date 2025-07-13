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

    public function show($id)
    {
        $ulasan = Ulasan::with('user')->findOrFail($id);
        return view('admin.ulasan.show', compact('ulasan'));
    }

    public function destroy($id)
    {
        $ulasan = Ulasan::findOrFail($id);
        if ($ulasan->gambar) {
            Storage::disk('public')->delete($ulasan->gambar);
        }
        $ulasan->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
