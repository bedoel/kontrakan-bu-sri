<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;

use App\Http\Controllers\UserHomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\UserKontrakanController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SewaController as AdminSewaController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;
use App\Http\Controllers\Admin\KontrakanController as AdminKontrakanController;
use App\Http\Controllers\Admin\UlasanController as AdminUlasanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LaporanController;

// ===================================
// Email Verification Routes
// ===================================
Route::middleware('auth:user')->group(function () {
    Route::get('/email/verify', fn() => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('user.home');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user('user')->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi dikirim ulang!');
    })->middleware('throttle:6,1')->name('verification.send');
});

// ===================================
// Guest Routes
// ===================================
Route::get('/', [UserHomeController::class, 'index'])->name('user.home');
Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');

// ===================================
// Auth Routes
// ===================================
// -- User
Route::get('/user/login', [UserAuthController::class, 'showLogin'])->name('user.login');
Route::get('/login', fn() => redirect()->route('user.login'))->name('login');
Route::post('/user/login', [UserAuthController::class, 'login']);
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('user.register');
Route::post('/register', [UserAuthController::class, 'register']);

// -- Admin
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::get('/admin-login', fn() => redirect()->route('admin.login'))->name('login.admin');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// ===================================
// User Routes (Auth & Verified)
// ===================================
Route::middleware(['auth:user'])->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');

    Route::middleware(['verified'])->group(function () {
        // Sewa
        Route::get('/user/sewa/create/{kontrakan:slug}', [SewaController::class, 'create'])->name('user.sewa.create');
        Route::post('/user/sewa/store', [SewaController::class, 'store'])->name('user.sewa.store');
        Route::get('/user/sewa/{sewa:slug}', [SewaController::class, 'show'])->name('user.sewa.show');
        Route::get('/sewa', [SewaController::class, 'index'])->name('user.sewa.index');
        Route::put('/sewa/{sewa}/batal', [SewaController::class, 'batal'])->name('user.sewa.batal');
        Route::post('/sewa/{sewa}/perpanjang', [SewaController::class, 'perpanjang'])->name('user.sewa.perpanjang');

        // Transaksi
        Route::get('/user/sewa/{sewa}/bayar', [TransaksiController::class, 'create'])->name('user.transaksi.create');
        Route::post('/user/sewa/{sewa}/bayar', [TransaksiController::class, 'store'])->name('user.transaksi.store');

        Route::prefix('user')->name('user.')->group(function () {
            // Transaksi
            Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
            Route::get('/transaksi/{invoice_number}', [TransaksiController::class, 'show'])->name('transaksi.show');
            Route::get('/transaksi/{invoice_number}/invoice', [TransaksiController::class, 'invoice'])->name('transaksi.invoice');

            // Pengaduan
            Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
            Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
            Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
            Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
            Route::post('/pengaduan/{pengaduan}/balas', [PengaduanController::class, 'balas'])->name('pengaduan.balas');

            // Ulasan
            Route::prefix('ulasan')->name('ulasan.')->group(function () {
                Route::get('/saya', [UlasanController::class, 'myulasan'])->name('index');
                Route::get('/create', [UlasanController::class, 'create'])->name('create');
                Route::post('/store', [UlasanController::class, 'store'])->name('store');
                Route::get('/{ulasan}/edit', [UlasanController::class, 'edit'])->name('edit');
                Route::put('/{ulasan}', [UlasanController::class, 'update'])->name('update');
                Route::delete('/{ulasan}', [UlasanController::class, 'destroy'])->name('destroy');
            });

            // Profile
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        });
    });
});

// ===================================
// Admin Routes (Auth)
// ===================================
Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {
    // Dashboard & Logout
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Profile
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // Resource
    Route::resource('kontrakan', AdminKontrakanController::class);
    Route::resource('sewa', AdminSewaController::class)->names('sewa');
    Route::resource('transaksi', AdminTransaksiController::class)->names('transaksi');

    // Perpanjang Sewa
    Route::get('/sewa/{sewa}/perpanjang', [AdminSewaController::class, 'formPerpanjang'])->name('sewa.perpanjang.form');
    Route::post('/sewa/{sewa}/perpanjang', [AdminSewaController::class, 'simpanPerpanjang'])->name('sewa.perpanjang.simpan');

    // Pengaduan
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::delete('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    Route::post('/pengaduan/{pengaduan}/balas', [AdminPengaduanController::class, 'balas'])->name('pengaduan.balas');
    Route::post('/pengaduan/{pengaduan}/ubah-status', [AdminPengaduanController::class, 'ubahStatus'])->name('pengaduan.ubahStatus');

    // Ulasan
    Route::get('/ulasan', [AdminUlasanController::class, 'index'])->name('ulasan.index');
    Route::get('/ulasan/{ulasan}', [AdminUlasanController::class, 'show'])->name('ulasan.show');
    Route::delete('/ulasan/{ulasan}', [AdminUlasanController::class, 'destroy'])->name('ulasan.destroy');

    // Users
    Route::resource('users', UserController::class);
    Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('transaksi/excel', [LaporanController::class, 'exportTransaksiExcel'])->name('transaksi.excel');
        Route::get('transaksi/pdf', [LaporanController::class, 'exportTransaksiPdf'])->name('transaksi.pdf');
        Route::get('pengaduan/excel', [LaporanController::class, 'exportPengaduanExcel'])->name('pengaduan.excel');
        Route::get('pengaduan/pdf', [LaporanController::class, 'exportPengaduanPdf'])->name('pengaduan.pdf');
        Route::get('sewa/excel', [LaporanController::class, 'exportSewaExcel'])->name('sewa.excel');
        Route::get('sewa/pdf', [LaporanController::class, 'exportSewaPdf'])->name('sewa.pdf');
    });

    // Superadmin-only
    Route::middleware('superadmin')->group(function () {
        Route::resource('admins', AdminController::class);
    });
});

// ===================================
// Public Kontrakan Routes
// ===================================
Route::prefix('kontrakan')->name('user.kontrakan.')->group(function () {
    Route::get('/', [UserKontrakanController::class, 'index'])->name('index');
    Route::get('/{slug}', [UserKontrakanController::class, 'show'])->name('show');
});
