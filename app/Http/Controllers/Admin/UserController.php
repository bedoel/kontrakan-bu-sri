<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nomor_hp' => 'required|numeric|digits_between:10,15',
            'poto_profil' => 'nullable|mimes:jpg,jpeg,png|max:2048', // Ganti image jadi mimes
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal 255 karakter.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',

            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.numeric' => 'Nomor HP harus berupa angka.',
            'nomor_hp.digits_between' => 'Nomor HP harus antara 10 sampai 15 digit.',

            'poto_profil.mimes' => 'Foto profil harus berupa file JPG, JPEG, atau PNG.',
            'poto_profil.max' => 'Ukuran foto maksimal 2MB.',

            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);


        $data = $request->only(['name', 'email', 'nomor_hp']);
        $data['password'] = bcrypt($request->password);

        if ($request->hasFile('poto_profil')) {
            $data['poto_profil'] = $request->file('poto_profil')->store('foto_profil', 'public');
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }


    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nomor_hp' => 'required|numeric|digits_between:10,15',
            'poto_profil' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
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

            'poto_profil.mimes' => 'Foto profil harus berupa file JPG, JPEG, atau PNG.',
            'poto_profil.max' => 'Ukuran foto maksimal 2MB.',

            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = $request->only(['name', 'email', 'nomor_hp']);

        // Update poto_profil jika ada
        if ($request->hasFile('poto_profil')) {
            if ($user->poto_profil && Storage::disk('public')->exists($user->poto_profil)) {
                Storage::disk('public')->delete($user->poto_profil);
            }
            $data['poto_profil'] = $request->file('poto_profil')->store('foto_profil', 'public');
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->poto_profil) {
            Storage::delete($user->poto_profil);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    // public function resetPassword(Request $request, User $user)
    // {
    //     $request->validate([
    //         'password' => 'required|string|min:6|confirmed',
    //     ], [
    //         'password.required' => 'Password wajib diisi.',
    //         'password.string' => 'Password harus berupa teks.',
    //         'password.min' => 'Password minimal 6 karakter.',
    //         'password.confirmed' => 'Konfirmasi password tidak cocok.',
    //     ]);

    //     $user->update(['password' => Hash::make($request->password)]);

    //     return redirect()->route('admin.users.show', $user->id)->with('success', 'Password berhasil direset.');
    // }
}
