<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontrakan;
use App\Models\FotoKontrakan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class KontrakanController extends Controller
{
    public function index()
    {
        $kontrakans = Kontrakan::with('foto_kontrakans')->latest()->get();
        return view('admin.kontrakan.index', compact('kontrakans'));
    }

    public function create()
    {
        return view('admin.kontrakan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'status' => 'required|in:tersedia,disewa,nonaktif',
            'foto_kontrakans.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Nama kontrakan wajib diisi.',
            'nama.string' => 'Nama kontrakan harus berupa teks.',
            'nama.max' => 'Nama kontrakan maksimal 255 karakter.',

            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga minimal Rp1.',

            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',

            'status.required' => 'Status kontrakan wajib dipilih.',
            'status.in' => 'Status hanya boleh: tersedia, disewa, atau nonaktif.',

            'foto_kontrakans.*.image' => 'Setiap file harus berupa gambar.',
            'foto_kontrakans.*.mimes' => 'Format gambar hanya boleh JPG, JPEG, atau PNG.',
            'foto_kontrakans.*.max' => 'Ukuran gambar maksimal 2MB per file.',
        ]);


        $kontrakan = Kontrakan::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama) . '-' . uniqid(),
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        if ($request->hasFile('foto_kontrakans')) {
            foreach ($request->file('foto_kontrakans') as $file) {
                $path = $file->store('foto_kontrakans', 'public');
                FotoKontrakan::create([
                    'kontrakan_id' => $kontrakan->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('admin.kontrakan.index')
            ->with('success', 'Data kontrakan berhasil disimpan.');
    }

    public function edit($id)
    {
        $kontrakan = Kontrakan::with('foto_kontrakans')->findOrFail($id);
        return view('admin.kontrakan.edit', compact('kontrakan'));
    }


    public function update(Request $request, Kontrakan $kontrakan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'status' => 'required|in:tersedia,disewa,nonaktif',
            'foto_kontrakans.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama.required' => 'Nama kontrakan wajib diisi.',
            'nama.string' => 'Nama kontrakan harus berupa teks.',
            'nama.max' => 'Nama kontrakan maksimal 255 karakter.',

            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga minimal Rp1.',

            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',

            'status.required' => 'Status kontrakan wajib dipilih.',
            'status.in' => 'Status hanya boleh: tersedia, disewa, atau nonaktif.',

            'foto_kontrakans.*.image' => 'Setiap file harus berupa gambar.',
            'foto_kontrakans.*.mimes' => 'Format gambar hanya boleh JPG, JPEG, atau PNG.',
            'foto_kontrakans.*.max' => 'Ukuran gambar maksimal 2MB per file.',
        ]);

        $kontrakan->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama),
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
        ]);

        if ($request->hasFile('foto_kontrakans')) {
            // Hapus foto lama
            foreach ($kontrakan->foto_kontrakans as $foto) {
                Storage::disk('public')->delete($foto->path);
                $foto->delete();
            }

            // Simpan yang baru
            foreach ($request->file('foto_kontrakans') as $file) {
                $path = $file->store('foto_kontrakan', 'public');
                FotoKontrakan::create([
                    'kontrakan_id' => $kontrakan->id,
                    'path' => $path
                ]);
            }
        }

        return redirect()->route('admin.kontrakan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Kontrakan $kontrakan)
    {
        foreach ($kontrakan->foto_kontrakans as $foto) {
            Storage::disk('public')->delete($foto->path);
            $foto->delete();
        }

        $kontrakan->delete();

        return redirect()->route('admin.kontrakan.index')->with('success', 'Data berhasil dihapus.');
    }
}
