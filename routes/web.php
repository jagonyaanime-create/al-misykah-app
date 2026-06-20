<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WaliController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Wali\WaliDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SantriController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PelanggaranController;

Route::redirect('/', '/login');

// Route Login
Route::get('/login', function () { return view('login'); })->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Akses Pengurus (Admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // Anda bisa menambah rute admin lainnya di sini (contoh: kelola santri, kelola tagihan)
    Route::resource('users', UserController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('santri', SantriController::class);
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/quick', [AbsensiController::class, 'quick'])->name('absensi.quick');
    Route::get('/pembayaran-login', [PembayaranController::class, 'showAuthForm'])->name('pembayaran.auth');
    Route::post('/pembayaran-login', [PembayaranController::class, 'verifyAuth']);

    Route::post('/absensi/bulk', [AbsensiController::class, 'bulkStore'])->name('absensi.bulk_store');
    Route::get('/pembayaran', [PembayaranController::class, 'index']);
    Route::resource('pembayaran', PembayaranController::class);

    // Route khusus untuk fungsi Masal (Bulk)
    Route::post('/generate-spp', [PembayaranController::class, 'generateSPP'])->name('pembayaran.generate_spp');
    Route::post('/tagihan-masal', [PembayaranController::class, 'tagihanMasal'])->name('pembayaran.tagihan_masal');

    // Route khusus untuk tombol lunas kilat
    Route::put('/pembayaran-lunas/{id}', [PembayaranController::class, 'lunas'])->name('pembayaran.lunas');
    Route::post('/pembayaran/bayar', [PembayaranController::class, 'bayar']);
    Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran', [PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/pelanggaran', [PelanggaranController::class, 'index']);
    Route::post('/pelanggaran', [PelanggaranController::class, 'store']);
});

// 2. Lindungi menu pembayaran yang sudah ada dengan middleware kita tadi
Route::middleware(['auth', \App\Http\Middleware\VerifyPaymentAccess::class])->group(function () {
    Route::resource('pembayaran', PembayaranController::class);
    // Masukkan route masal kemarin ke sini juga agar ikut terkunci
    Route::post('/generate-spp', [PembayaranController::class, 'generateSPP'])->name('pembayaran.generate_spp');
    Route::post('/tagihan-masal', [PembayaranController::class, 'tagihanMasal'])->name('pembayaran.tagihan_masal');
});

// Group Akses Wali Santri
Route::middleware(['auth', 'role:wali'])->prefix('wali')->group(function () {
    Route::get('/dashboard', [WaliDashboardController::class, 'index'])->name('wali.dashboard');
    // Rute Baru untuk Data Anak
    Route::get('/santri', [WaliDashboardController::class, 'santri'])->name('wali.santri');
    // Rute Absensi Wali
     Route::get('/wali/absensi', [WaliDashboardController::class, 'absensi'])->name('wali.absensi');
     Route::get('/wali/keuangan', [WaliDashboardController::class, 'keuangan'])->name('wali.keuangan');
     Route::get('/wali/pelanggaran', [WaliDashboardController::class, 'pelanggaran'])->name('wali.pelanggaran');
});
