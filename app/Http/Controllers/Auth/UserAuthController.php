<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.user.login');
    }

    public function showRegister()
    {
        return view('auth.user.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('user')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('user.home');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nomor_hp' => 'required|numeric|digits_between:10,15',
            'password' => 'required|confirmed|min:6',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'nomor_hp.required' => 'Nomor HP wajib diisi.',
            'nomor_hp.numeric' => 'Nomor HP harus berupa angka.',
            'nomor_hp.digits_between' => 'Nomor HP harus antara 10 sampai 15 digit.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'password' => Hash::make($request->password),
        ]);

        $user->sendEmailVerificationNotification();

        Auth::guard('user')->login($user); // langsung login
        return redirect()->route('verification.notice');
    }


    public function logout(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
