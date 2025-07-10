<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimoni;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::latest()->get();
        return view('testimoni.index', compact('testimonis'));
    }

    public function mytestimoni()
    {
        $testimonis = Testimoni::where('user_id', Auth::id())->latest()->get();
        return view('user.testimoni.index', compact('testimonis'));
    }

    public function create()
    {
        return view('user.testimoni.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pesan' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048'
        ], [
            'pesan.required' => 'Pesan wajib diisi.',
            'rating.required' => 'Rating wajib diisi.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
        ]);

        $gambar = $request->file('gambar') ? $request->file('gambar')->store('testimoni', 'public') : null;

        Testimoni::create([
            'user_id' => Auth::id(),
            'pesan' => $request->pesan,
            'rating' => $request->rating,
            'gambar' => $gambar,
        ]);

        return redirect()->route('user.testimoni.index')->with('success', 'Testimoni berhasil dikirim.');
    }

    public function edit(Testimoni $testimoni)
    {
        if ($testimoni->user_id !== auth('user')->id()) {
            abort(403, 'Anda tidak berhak mengakses ulasan ini.');
        }
        $this->authorizeTestimoni($testimoni);
        return view('user.testimoni.edit', compact('testimoni'));
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        if ($testimoni->user_id !== auth('user')->id()) {
            abort(403, 'Anda tidak berhak mengakses ulasan ini.');
        }
        $this->authorizeTestimoni($testimoni);

        $request->validate([
            'pesan' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'gambar' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'pesan.required' => 'Pesan wajib diisi.',
            'rating.required' => 'Rating wajib diisi.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
        ]);

        $data = $request->only(['pesan', 'rating']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('testimoni', 'public');
        }

        $testimoni->update($data);

        return redirect()->route('user.testimoni.index')->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimoni $testimoni)
    {
        $this->authorizeTestimoni($testimoni);
        $testimoni->delete();
        return redirect()->route('user.testimoni.index')->with('success', 'Testimoni berhasil dihapus.');
    }

    protected function authorizeTestimoni(Testimoni $testimoni)
    {
        if ($testimoni->user_id !== auth('user')->id()) {
            abort(403);
        }
    }
}
