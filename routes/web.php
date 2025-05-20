<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PemesananController;  
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AdminPemesananController;
use App\Http\Controllers\AdminMobilController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/redirect-dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'user') {
        return redirect()->route('user.dashboard');
    } else {
        return redirect()->route('landing'); // fallback
    }
});

Route::get('/', [DashboardController::class, 'landing'])->name('landing');

// Untuk user
Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('user/dashboard', [DashboardController::class, 'userDashboard'])->name('user.dashboard');
});
// Untuk admin  
Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
});

Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/pemesanan/form/{mobil}', [PemesananController::class, 'form'])->name('pemesanan.form');
    Route::post('/pemesanan/form/{mobil}', [PemesananController::class, 'store'])->name('pemesanan.store');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/mobil', [MobilController::class, 'userDashboard'])->name('dashboard');

// Tampilkan detail mobil
Route::get('/mobil/{id}', [MobilController::class, 'show'])->name('mobil.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/pembayaran/{pemesanan}/konfirmasi', [PembayaranController::class, 'konfirmasi'])->name('konfirmasi');
    Route::get('/pembayaran/{pemesanan}/konfirmasi', [PembayaranController::class, 'create'])->name('pembayaran.konfirmasi');
    Route::get('/pembayaran/{pemesanan}/selesai', [PembayaranController::class, 'selesai'])->name('pembayaran.selesai');
    Route::post('/pembayaran/konfirmasi/simpan', [PembayaranController::class, 'simpan'])->name('pembayaran.konfirmasi.simpan');
});

Route::get('/pembayaran/{mobil}', [PembayaranController::class, 'show'])->name('pembayaran.show');

Route::get('/user/pembayaran/{pemesanan}', [PembayaranController::class, 'show'])->name('user.pembayaran'); 

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pemesanan', [AdminPemesananController::class, 'index'])->name('admin.pemesanan.index');
    Route::get('/admin/pemesanan/{id}', [AdminPemesananController::class, 'show'])->name('admin.pemesanan.detail');
    Route::post('/admin/pemesanan/{id}/verifikasi', [AdminPemesananController::class, 'verifikasi'])->name('admin.pemesanan.verifikasi');
    Route::post('/admin/pemesanan/{id}/tolak', [PemesananController::class, 'tolak'])->name('admin.pemesanan.tolak');
    Route::delete('/admin/pemesanan/{id}', [AdminPemesananController::class, 'destroy'])->name('admin.pemesanan.destroy');
});

Route::get('/user/riwayat', [PemesananController::class, 'riwayat'])
    ->name('user.pemesanan.riwayat')
    ->middleware(['auth']);

Route::middleware(['auth', 'checkRole:user'])->group(function () {
    // Route untuk detail pemesanan user
    Route::get('/user/pemesanan/{id}', [PemesananController::class, 'show'])->name('user.pemesanan.show');
});

Route::get('/user/riwayat', [PemesananController::class, 'riwayat'])->middleware('auth')->name('user.riwayat');

Route::get('/user/pemesanan/aktif', [PemesananController::class, 'aktif'])
    ->middleware(['auth', 'checkRole:user'])
    ->name('user.pemesanan.aktif');

Route::middleware(['auth', 'checkRole:user'])->group(function () {
    Route::get('/user/pemesanan', [PemesananController::class, 'index'])->name('user.pemesanan.index');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('mobil', AdminMobilController::class);
});

Route::post('/admin/mobil', [MobilController::class, 'store'])->name('admin.mobil.store');

Route::post('/user/pemesanan/{id}/batalkan', [PemesananController::class, 'batalkan'])->name('user.pemesanan.batalkan');

Route::post('/admin/pembatalan/{id}/setujui', [AdminPemesananController::class, 'setujuiPembatalan'])->name('admin.pembatalan.approve');
Route::post('/admin/pembatalan/{id}/tolak', [AdminPemesananController::class, 'tolakPembatalan'])->name('admin.pembatalan.reject');
    

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');



require __DIR__.'/auth.php';
