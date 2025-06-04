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
use App\Http\Controllers\AdminPenyerahanController;
use App\Http\Controllers\User\PembatalanController;
use App\Notifications\VerifikasiPembayaranNotification;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MasalahController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminPengembalianController;
use App\Http\Controllers\PengembalianUangController;
use App\Http\Controllers\PembatalanDisetujuiController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PerjanjianController;
use App\Http\Controllers\UserDendaController;

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
    Route::delete('/admin/pemesanan/{id}', [AdminPemesananController::class, 'destroy'])->name('admin.pemesanan.destroy');
    Route::post('/admin/pemesanan/{id}/terima-kembali', [AdminPemesananController::class, 'terimaKembali'])->name('admin.pemesanan.terima_kembali');
    Route::get('/admin/pembatalan', [AdminPemesananController::class, 'pembatalanIndex'])->name('admin.pembatalan.index');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::post('/admin/pemesanan/{id}/tolak', [AdminPemesananController::class, 'tolak'])->name('admin.pemesanan.tolak');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Penyerahan
    Route::get('penyerahan', [AdminPenyerahanController::class, 'index'])->name('penyerahan');
    Route::put('penyerahan/{id}', [AdminPenyerahanController::class, 'update'])->name('penyerahan.update');
    Route::post('penyerahan/{id}/serahkan', [AdminPenyerahanController::class, 'serahkan'])->name('penyerahan.serahkan');

    // // Pengembalian
    // Route::get('pengembalian', [AdminPenyerahanController::class, 'index'])->name('pengembalian');
    // Route::put('pengembalian/{id}/verifikasi', [AdminPemesananController::class, 'verifikasiPengembalian'])->name('pengembalian.verifikasi');

});

// routes/web.php
Route::get('/pengembalian-uang/{id}', [PengembalianUangController::class, 'show'])->name('pengembalian.uang');


Route::get('/user/riwayat', [PemesananController::class, 'riwayat'])
    ->name('user.pemesanan.riwayat')
    ->middleware(['auth']);

Route::middleware(['auth', 'checkRole:user'])->group(function () {
    // Route untuk detail pemesanan user
    Route::get('/user/pemesanan/{id}', [PemesananController::class, 'show'])->name('user.pemesanan.show');
});

Route::get('/user/riwayat', [PemesananController::class, 'riwayat'])->middleware('auth')->name('user.riwayat');

Route::post('/pengembalian/ajukan/{id}', [PemesananController::class, 'ajukanPengembalian'])->name('user.pengembalian.ajukan');

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

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::post('admin/pembatalan/{id}/approve', [PembatalanController::class, 'approve'])->name('admin.pembatalan.approve');
    Route::post('admin/pembatalan/{id}/reject', [PembatalanController::class, 'reject'])->name('admin.pembatalan.reject');
});

Route::get('/test-notif', function () {
    $user = User::find(2); // Ganti sesuai ID user kamu
    $user->notify(new VerifikasiPembayaranNotification());

    return 'Notifikasi terkirim!';
});

// Route::middleware(['auth'])->group(function () {
//     Route::get('/notifikasi', [NotificationController::class, 'index'])->name('user.notifikasi');
//     Route::post('/notifikasi/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
//     Route::post('/notifikasi/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
// });

// Route::get('/faq', function () {
//     return view('user.faq');
// })->middleware(['auth', 'verified'])->name('faq');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/faq', [FaqController::class, 'index'])->name('faq');
    Route::get('/faq/{id}', [FaqController::class, 'show'])->name('faq.show');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/lapor-masalah', [MasalahController::class, 'index'])->name('user.lapor-masalah');
    Route::post('/lapor-masalah/kirim', [MasalahController::class, 'kirim'])->name('user.lapor-masalah.kirim');
});

Route::post('/lapor', [MasalahController::class, 'store'])->name('user.lapor-masalah.store');

Route::middleware(['auth', 'checkRole:admin'])->group(function () {
    Route::get('/admin/laporan-masalah', [AdminLaporanController::class, 'index'])->name('admin.laporan-masalah.index');
});

Route::get('/lapor/create', [MasalahController::class, 'create'])->name('lapor.create');

// routes/web.php
Route::get('/admin/pembatalan-disetujui', [PembatalanDisetujuiController::class, 'approved'])->name('admin.pembatalan.disetujui');
Route::post('/admin/proses-refund/{id}', [PembatalanDisetujuiController::class, 'prosesRefund'])->name('admin.proses.refund');


Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.form');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::get('/admin/feedbacks', [FeedbackController::class, 'index'])->middleware('admin');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/feedbacks', [FeedbackController::class, 'index'])->name('admin.feedback');
});

Route::get('/invoice/download/{id}', [PemesananController::class, 'downloadInvoice'])->name('invoice.download');

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function() {
    Route::get('/verifikasi-pengembalian', [AdminPengembalianController::class, 'verifikasiPengembalian'])->name('admin.verifikasi-pengembalian');
    Route::post('/verifikasi-pengembalian/{id}', [AdminPengembalianController::class, 'prosesVerifikasi'])->name('admin.proses_verifikasi');
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/riwayat-pemesanan', [DashboardController::class, 'riwayatPemesanan'])->name('riwayat-pemesanan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/notifikasi', [DashboardController::class, 'notifikasi'])->name('user.notifikasi');
    Route::post('/user/notifikasi/{id}/read', [DashboardController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/user/notifikasi/all-read', [DashboardController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/pengguna', [\App\Http\Controllers\AdminPemesananController::class, 'daftarPengguna'])->name('admin.pengguna');
});

Route::post('/admin/pemesanan/{id}/upload-perjanjian', [AdminPemesananController::class, 'uploadPerjanjian'])->name('admin.uploadPerjanjian');

Route::get('/download-perjanjian', [PerjanjianController::class, 'generatePdf'])->name('download.perjanjian');

Route::middleware(['auth'])->group(function () {
    Route::get('/bayar-denda-bbm/{id}', [UserDendaController::class, 'formPembayaranBBM'])->name('user.bayar-denda-bbm');
    Route::post('/bayar-denda-bbm/{id}', [UserDendaController::class, 'prosesPembayaranBBM'])->name('user.proses-bayar-denda-bbm');
});

Route::get('/admin/denda-bbm', [AdminPengembalianController::class, 'dendaBBM'])->name('admin.denda-bbm');
Route::post('/admin/verifikasi-denda-bbm/{id}', [AdminPengembalianController::class, 'verifikasiDendaBBM'])->name('admin.verifikasi-denda-bbm');


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::post('/logout', [AuthenticatedSessionContraoller::class, 'destroy'])->middleware('auth')->name('logout');


require __DIR__.'/auth.php';
