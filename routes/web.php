<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SewaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserHomeController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\UserKontrakanController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\PindahKontrakanController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Admin\SewaController as AdminSewaController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KontrakanController as AdminKontrakanController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;

use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\PindahKontrakanController as AdminPindahKontrakanController;

// Tampilkan halaman setelah klik link
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth:user')->name('verification.notice');

// Link verifikasi di email menuju ke sini
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // menandai verified
    return redirect()->route('user.home');
})->middleware(['auth:user', 'signed'])->name('verification.verify');

// Jika perlu kirim ulang
Route::post('/email/verification-notification', function (Request $request) {
    $request->user('user')->sendEmailVerificationNotification();
    return back()->with('message', 'Link verifikasi dikirim ulang!');
})->middleware(['auth:user', 'throttle:6,1'])->name('verification.send');


// ===================================
// Guest Routes
// ===================================
Route::get('/', [UserHomeController::class, 'index'])->name('user.home');
Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni.index');

// ===================================
// User Auth Routes
// ===================================
Route::get('/user/login', [UserAuthController::class, 'showLogin'])->name('user.login');
Route::get('/login', fn() => redirect()->route('user.login'))->name('login'); // fallback ke login user
Route::post('/user/login', [UserAuthController::class, 'login']);
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('user.register');
Route::post('/register', [UserAuthController::class, 'register']);


// ===================================
// Admin Auth Routes
// ===================================
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::get('/admin-login', fn() => redirect()->route('admin.login'))->name('login.admin'); // fallback opsional
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// ===================================
// User Routes (Auth Required)
// ===================================
Route::middleware(['auth:user'])->group(function () {
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('user.logout');
});
Route::middleware(['auth:user', 'verified'])->group(function () {
    // Sewa Kontrakan
    Route::get('/user/sewa/create/{kontrakan}', [SewaController::class, 'create'])->name('user.sewa.create');
    Route::post('/user/sewa/store', [SewaController::class, 'store'])->name('user.sewa.store');
    Route::get('/user/sewa/{sewa}', [SewaController::class, 'show'])->name('user.sewa.show');
    Route::get('/sewa', [SewaController::class, 'index'])->name('user.sewa.index');
    Route::put('/sewa/{id}/batal', [SewaController::class, 'batal'])->name('user.sewa.batal');
    Route::post('/sewa/{sewa}/perpanjang', [SewaController::class, 'perpanjang'])->name('user.sewa.perpanjang');

    // Transaksi
    Route::get('/user/sewa/{sewa}/bayar', [TransaksiController::class, 'create'])->name('user.transaksi.create');
    Route::post('/user/sewa/{sewa}/bayar', [TransaksiController::class, 'store'])->name('user.transaksi.store');

    Route::name('user.')->group(function () {
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
        Route::get('/transaksi/{transaksi}/invoice', [TransaksiController::class, 'invoice'])->name('transaksi.invoice');

        // Pindah Kontrakan
        Route::get('/pindah-kontrakan', [PindahKontrakanController::class, 'create'])->name('pindah.create');
        Route::post('/pindah-kontrakan', [PindahKontrakanController::class, 'store'])->name('pindah.store');

        // Pengaduan
        Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
        Route::get('/pengaduan/create', [PengaduanController::class, 'create'])->name('pengaduan.create');
        Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
        Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
        Route::post('/pengaduan/{pengaduan}/balas', [PengaduanController::class, 'balas'])->name('pengaduan.balas');

        // Testimoni
        Route::prefix('testimoni')->name('testimoni.')->group(function () {
            Route::get('/saya', [TestimoniController::class, 'mytestimoni'])->name('index');
            Route::get('/create', [TestimoniController::class, 'create'])->name('create');
            Route::post('/store', [TestimoniController::class, 'store'])->name('store');
            Route::get('/{testimoni}/edit', [TestimoniController::class, 'edit'])->name('edit');
            Route::put('/{testimoni}', [TestimoniController::class, 'update'])->name('update');
            Route::delete('/{testimoni}', [TestimoniController::class, 'destroy'])->name('destroy');
        });
    });
});

// ===================================
// Admin Routes (Auth Required)
// ===================================
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Perpanjang Sewa
    // Route::get('/sewa/{sewa}/perpanjang', [AdminSewaController::class, 'formPerpanjang'])->name('sewa.formPerpanjang');
    // Route::post('/sewa/{sewa}/perpanjang', [AdminSewaController::class, 'simpanPerpanjang'])->name('sewa.simpanPerpanjang');

    // Resource Routes
    Route::resource('kontrakan', AdminKontrakanController::class);
    Route::resource('sewa', AdminSewaController::class)->names('sewa');
    Route::resource('transaksi', AdminTransaksiController::class)->names('transaksi');

    // Pindah Kontrakan
    Route::get('/pindah', [AdminPindahKontrakanController::class, 'index'])->name('pindah.index');
    Route::get('/pindah/{pindah}', [AdminPindahKontrakanController::class, 'destroy'])->name('pindah.destroy');
    Route::get('/pindah/{pindah}/show', [AdminPindahKontrakanController::class, 'show'])->name('pindah.show');
    Route::post('/pindah/{pindah}/konfirmasi', [AdminPindahKontrakanController::class, 'konfirmasi'])->name('pindah.konfirmasi');

    // Pengaduan
    Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [AdminPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::post('/pengaduan/{pengaduan}/balas', [AdminPengaduanController::class, 'balas'])->name('pengaduan.balas');
    Route::patch('/pengaduan/{pengaduan}/ubah-status', [AdminPengaduanController::class, 'ubahStatus'])->name('pengaduan.ubah-status');

    Route::get('/testimoni', [\App\Http\Controllers\Admin\TestimoniController::class, 'index'])->name('testimoni.index');
    Route::get('/testimoni/{id}', [\App\Http\Controllers\Admin\TestimoniController::class, 'show'])->name('testimoni.show');
    Route::delete('/testimoni/{id}', [\App\Http\Controllers\Admin\TestimoniController::class, 'destroy'])->name('testimoni.destroy');
});

// ===================================
// Public Kontrakan Routes
// ===================================
Route::prefix('kontrakan')->name('user.kontrakan.')->group(function () {
    Route::get('/', [UserKontrakanController::class, 'index'])->name('index');
    Route::get('/{id}', [UserKontrakanController::class, 'show'])->name('show');
});


Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{user}/reset-password', [\App\Http\Controllers\Admin\UserController::class, 'resetPassword'])->name('users.reset-password');
});

Route::middleware(['auth:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ADMIN
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

Route::prefix('admin/laporan')->name('admin.laporan.')->group(function () {
    Route::get('transaksi/excel', [LaporanController::class, 'exportTransaksiExcel'])->name('transaksi.excel');
    Route::get('transaksi/pdf', [LaporanController::class, 'exportTransaksiPdf'])->name('transaksi.pdf');

    Route::get('pengaduan/excel', [LaporanController::class, 'exportPengaduanExcel'])->name('pengaduan.excel');
    Route::get('pengaduan/pdf', [LaporanController::class, 'exportPengaduanPdf'])->name('pengaduan.pdf');

    Route::get('pindah/excel', [LaporanController::class, 'exportPindahExcel'])->name('pindah.excel');
    Route::get('pindah/pdf', [LaporanController::class, 'exportPindahPdf'])->name('pindah.pdf');

    Route::get('sewa/excel', [LaporanController::class, 'exportSewaExcel'])->name('sewa.excel');
    Route::get('sewa/pdf', [LaporanController::class, 'exportSewaPdf'])->name('sewa.pdf');
});

Route::prefix('admin/sewa')->name('admin.sewa.')->middleware('auth:admin')->group(function () {
    Route::get('/{sewa}/perpanjang', [AdminSewaController::class, 'formPerpanjang'])->name('perpanjang.form');
    Route::post('/{sewa}/perpanjang', [AdminSewaController::class, 'simpanPerpanjang'])->name('perpanjang.simpan');
});
