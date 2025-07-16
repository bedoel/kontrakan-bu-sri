<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->get();
        return view('admin.admins.index', compact('admins'));
    }

    public function show(Admin $admin)
    {
        return view('admin.admins.show', compact('admin'));
    }

    public function create()
    {
        return view('admin.admins.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|unique:admins,email|max:150',
            'nomor_hp' => 'required|numeric|digits_between:10,15',
            'poto_profil' => 'nullable|mimes:jpg,jpeg,png|max:2048',
            'role'       => 'required|in:admin,super_admin',
            'password'   => 'required|string|min:6|confirmed',
        ], [
            'name.required'       => 'Nama wajib diisi',
            'email.required'      => 'Email wajib diisi',
            'email.unique'        => 'Email sudah terdaftar',
            'role.required'       => 'Role wajib dipilih',
            'password.required'   => 'Password wajib diisi',
            'password.confirmed'  => 'Konfirmasi password tidak cocok',
            'nomor_hp.required'   => 'Nomor HP wajib diisi.',
            'nomor_hp.numeric'    => 'Nomor HP harus berupa angka.',
            'nomor_hp.digits_between' => 'Nomor HP harus antara 10 sampai 15 digit.',
            'poto_profil.mimes' => 'Foto profil harus berupa file JPG, JPEG, atau PNG.',
            'poto_profil.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        Admin::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'nomor_hp'   => $request->nomor_hp,
            'role'       => $request->role,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name'       => 'required|string|max:100',
            'email'      => 'required|email|max:150|unique:admins,email,' . $admin->id,
            'nomor_hp'   => 'nullable|string|max:20',
            'role'       => 'required|in:admin,super_admin',
            'password'   => 'nullable|string|min:6|confirmed',
        ], [
            'name.required'       => 'Nama wajib diisi',
            'email.required'      => 'Email wajib diisi',
            'email.unique'        => 'Email sudah terdaftar',
            'role.required'       => 'Role wajib dipilih',
            'password.confirmed'  => 'Konfirmasi password tidak cocok',
        ]);

        $data = $request->only(['name', 'email', 'nomor_hp', 'role']);

        // Jika password diisi, hash dan update
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')->with('success', 'Data admin berhasil diperbarui.');
    }


    public function destroy(Admin $admin)
    {
        if (auth('admin')->id() === $admin->id) {
            return redirect()->route('admin.admins.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        if ($admin->role === 'super_admin' && auth('admin')->user()->role !== 'super_admin') {
            return redirect()->route('admin.admins.index')->with('error', 'Anda tidak memiliki izin menghapus super admin.');
        }

        if ($admin->poto_profil && Storage::disk('public')->exists($admin->poto_profil)) {
            Storage::disk('public')->delete($admin->poto_profil);
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil dihapus.');
    }
}
