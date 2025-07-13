<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UlasanController extends Controller
{
    public function index()
    {
        $ulasans = Ulasan::latest()->get();
        return view('ulasan.index', compact('ulasans'));
    }

    public function myulasan()
    {
        $ulasans = Ulasan::where('user_id', Auth::id())->latest()->get();
        return view('user.ulasan.index', compact('ulasans'));
    }

    public function create()
    {
        return view('user.ulasan.create');
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

        $gambar = $request->file('gambar') ? $request->file('gambar')->store('ulasan', 'public') : null;

        Ulasan::create([
            'user_id' => Auth::id(),
            'pesan' => $request->pesan,
            'rating' => $request->rating,
            'gambar' => $gambar,
        ]);

        return redirect()->route('user.ulasan.index')->with('success', 'Ulasan berhasil dikirim.');
    }

    public function edit(Ulasan $ulasan)
    {
        if ($ulasan->user_id !== auth('user')->id()) {
            abort(403, 'Anda tidak berhak mengakses ulasan ini.');
        }
        $this->authorizeUlasan($ulasan);
        return view('user.ulasan.edit', compact('ulasan'));
    }

    public function update(Request $request, Ulasan $ulasan)
    {
        if ($ulasan->user_id !== auth('user')->id()) {
            abort(403, 'Anda tidak berhak mengakses ulasan ini.');
        }
        $this->authorizeUlasan($ulasan);

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
            $data['gambar'] = $request->file('gambar')->store('ulasan', 'public');
        }

        $ulasan->update($data);

        return redirect()->route('user.ulasan.index')->with('success', 'ulasan berhasil diperbarui.');
    }

    public function destroy(Ulasan $ulasan)
    {
        $this->authorizeUlasan($ulasan);
        $ulasan->delete();
        return redirect()->route('user.ulasan.index')->with('success', 'Ulasan berhasil dihapus.');
    }

    protected function authorizeUlasan(Ulasan $ulasan)
    {
        if ($ulasan->user_id !== auth('user')->id()) {
            abort(403);
        }
    }
}
