<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimoni;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::with('user')->latest()->get();
        return view('admin.testimoni.index', compact('testimonis'));
    }

    public function show($id)
    {
        $testimoni = Testimoni::with('user')->findOrFail($id);
        return view('admin.testimoni.show', compact('testimoni'));
    }

    public function destroy($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        if ($testimoni->gambar) {
            Storage::disk('public')->delete($testimoni->gambar);
        }
        $testimoni->delete();

        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}
