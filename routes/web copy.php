<?php

use App\Models\User;
use App\Models\Admin;
use App\Models\Pengaduan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\UserHomeController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\UserKontrakanController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PindahKontrakanController;
use App\Http\Controllers\Admin\SewaController as AdminSewaController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\PindahKontrakanController as AdminPindahKontrakanController;


// Guest (homepage)
Route::get('/', [UserHomeController::class, 'index'])->name('user.home');

// Login & Register User
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('user.login');
Route::post('/login', [UserAuthController::class, 'login']);
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('user.register');
Route::post('/register', [UserAuthController::class, 'register']);

// Admin Login
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// User Protected Routes
Route::middleware(['auth:user'])->group(function () {
    // Route::get('/dashboard', function () {
    //     $user = \App\Models\User::find(session('user_id'));
    //     return view('dashboard.user', compact('user'));
    // })->name('user.dashboard');

    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    // Sewa (Form Sewa Kontrakan)
    // Route::get('/kontrakan/{id}/sewa', [SewaController::class, 'create'])->name('user.sewa.create');
    // Route::post('/kontrakan/{id}/sewa', [SewaController::class, 'store'])->name('user.sewa.store');

    // Proses sewa baru
    Route::get('/user/sewa/create/{kontrakan}', [SewaController::class, 'create'])->name('user.sewa.create');
    Route::post('/user/sewa/store', [SewaController::class, 'store'])->name('user.sewa.store');

    // Detail sewa
    Route::get('/user/sewa/{sewa}', [SewaController::class, 'show'])->name('user.sewa.show');

    Route::get('/user/sewa/{sewa}/bayar', [TransaksiController::class, 'create'])->name('user.transaksi.create');
    Route::post('/user/sewa/{sewa}/bayar', [TransaksiController::class, 'store'])->name('user.transaksi.store');
    Route::get('/sewa', [SewaController::class, 'index'])->name('user.sewa.index');
    Route::put('/sewa/{id}/batal', [SewaController::class, 'batal'])->name('user.sewa.batal');

    // Perpanjang sewa
    Route::post('/sewa/{sewa}/perpanjang', [SewaController::class, 'perpanjang'])
        ->name('user.sewa.perpanjang');
});

Route::middleware(['auth:user'])->name('user.')->group(function () {
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/invoice', [TransaksiController::class, 'invoice'])->name('transaksi.invoice');
});

Route::middleware(['auth:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/pindah-kontrakan', [PindahKontrakanController::class, 'create'])->name('pindah.create');
    Route::post('/pindah-kontrakan', [PindahKontrakanController::class, 'store'])->name('pindah.store');
});

Route::prefix('admin')->middleware(['auth:admin'])->name('admin.')->group(function () {
    Route::get('/pindah', [AdminPindahKontrakanController::class, 'index'])->name('pindah.index');
    Route::get('/pindah/{pindah}/show', [AdminPindahKontrakanController::class, 'show'])->name('pindah.show');
    Route::post('/pindah/{pindah}/konfirmasi', [AdminPindahKontrakanController::class, 'konfirmasi'])->name('pindah.konfirmasi');
});


// Kontrakan (Terbuka untuk semua user)
Route::prefix('kontrakan')->name('user.kontrakan.')->group(function () {
    Route::get('/', [UserKontrakanController::class, 'index'])->name('index');
    Route::get('/{id}', [UserKontrakanController::class, 'show'])->name('show');
});

// Dashboard Admin
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        $admin = Admin::find(session('admin_id'));
        return view('dashboard.admin', compact('admin'));
    })->name('admin.dashboard');

    Route::get('admin/sewa/{sewa}/perpanjang', [AdminSewaController::class, 'formPerpanjang'])->name('admin.sewa.formPerpanjang');
    Route::post('admin/sewa/{sewa}/perpanjang', [AdminSewaController::class, 'simpanPerpanjang'])->name('admin.sewa.simpanPerpanjang');


    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::resource('kontrakan', \App\Http\Controllers\Admin\KontrakanController::class);
});

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::resource('sewa', AdminSewaController::class, ['as' => 'admin']);
    Route::resource('transaksi', AdminTransaksiController::class, ['as' => 'admin']);
});




// USER
Route::middleware(['auth:user'])->group(function () {
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('user.pengaduan.index');
    Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('user.pengaduan.create');
    Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('user.pengaduan.store');
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('user.pengaduan.show');
    Route::post('/pengaduan/{pengaduan}/balas', [PengaduanController::class, 'balas'])->name('user.pengaduan.balas');
});

// ADMIN
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('admin.pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'show'])->name('admin.pengaduan.show');
    Route::post('/pengaduan/{pengaduan}/balas', [AdminPengaduanController::class, 'balas'])->name('admin.pengaduan.balas');
    Route::patch('/pengaduan/{pengaduan}/ubah-status', [AdminPengaduanController::class, 'ubahStatus'])->name('admin.pengaduan.ubah-status');
});

// USER ULASAN
Route::prefix('user/ulasan')->middleware('auth:user')->name('user.ulasan.')->group(function () {
    Route::get('/', [UlasanController::class, 'index'])->name('index');
    Route::get('create', [UlasanController::class, 'create'])->name('create');
    Route::post('store', [UlasanController::class, 'store'])->name('store');
});
