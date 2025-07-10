<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = auth('admin')->user();
        return view('admin.profile.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $admin = auth('admin')->user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'nomor_hp' => 'required|numeric|digits_between:10,15',
            'password' => 'nullable|string|min:6|confirmed',
            'poto_profil' => 'nullable|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 100 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.numeric' => 'Nomor HP harus berupa angka.',
            'nomor_hp.digits_between' => 'Nomor HP harus antara 10 sampai 15 digit.',

            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',

            'poto_profil.mimes' => 'Foto profil harus berformat JPG, JPEG, atau PNG.',
            'poto_profil.max' => 'Ukuran foto maksimal 2MB.',
        ]);


        if ($request->hasFile('poto_profil')) {
            $foto = $request->file('poto_profil')->store('foto_admin', 'public');
            $admin->poto_profil = $foto;
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->nomor_hp = $request->nomor_hp;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
