<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\VerifikasiPembayaranNotification;
use App\Models\Notifikasi;

class DashboardController extends Controller
{
    // Landing page
    public function landing()
    {
        $mobils = Mobil::take(3)->get();

        return view('dashboard', compact('mobils'))
               ->with('page', 'landing');
    }

    // Admin dashboard
    public function adminDashboard()
    {
        $mobils = Mobil::all();
        $jumlahPemesananBaru = Pemesanan::where('status', 'menunggu_verifikasi')->count();

         $user = auth()->user();
    $unreadNotifications = $user->unreadNotifications;

        return view('admin.dashboard', compact('mobils', 'jumlahPemesananBaru', 'unreadNotifications'))
               ->with('page', 'admin');
    }

    // User dashboard
    public function userDashboard()
    {
        $mobilTersedia = Mobil::where('status', 'tersedia')->get();
    $user = Auth::user();
    $pemesananUser = Pemesanan::with('mobil')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->take(3)
                        ->get();
    $pemesananTerbaru = Pemesanan::with('mobil')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->first();
    $draftPemesanan = Pemesanan::with('mobil')
                        ->where('user_id', $user->id)
                        ->where('status', 'draft')
                        ->get();

    $pemesananLengkap = Pemesanan::with('pengembalian')->where('user_id', auth()->id())->get();

    // Ambil notifikasi belum dibaca tanpa langsung menandainya sudah dibaca
    $unreadNotifications = $user->unreadNotifications;


    // dd($unreadNotifications);

    return view('user.dashboard', compact('mobilTersedia', 'pemesananUser', 'pemesananTerbaru', 'draftPemesanan', 'unreadNotifications', 'pemesananLengkap'));
    }

    // Backup atau alias dari admin dashboard
    public function index()
    {
        $jumlahPemesananBaru = Pemesanan::where('status', 'menunggu_verifikasi')->count();
        $pemesananTerbaru = Pemesanan::with('mobil')->orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('admin.dashboard', compact('jumlahPemesananBaru', 'pemesananTerbaru'));
    }

    // Riwayat pemesanan user
    public function riwayat()
    {
        $pemesanan = Pemesanan::with(['mobil', 'pembatalan'])
                        ->where('user_id', auth()->id())
                        ->latest()
                        ->get();

        return view('user.riwayat', compact('pemesanan'));
    }

//     public function notifikasi()
// {
//     $user = Auth::user();
//     $notifications = $user->notifications()->latest()->get();

//      // Tandai semua notif unread jadi read
//     $user->unreadNotifications->markAsRead();

//     return view('user.notifikasi', compact('notifications'));
// }

public function riwayatPemesanan()
{
    $pemesanan = Pemesanan::with(['mobil', 'pengembalian'])
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();

    return view('user.riwayat-pemesanan', compact('pemesanan'));
}

public function notifikasi()
{
    $user = auth()->user();
    $notifications = $user->notifikasis()->orderBy('created_at', 'desc')->get();

    dd($notifications);

    return view('user.notifikasi', compact('notifications'));
}

public function markAsRead($id)
{
    $notif = Notifikasi::findOrFail($id);
    if ($notif->user_id == auth()->id()) {
        $notif->update(['dibaca' => true]);
        return back()->with('success', 'Notifikasi berhasil ditandai sudah dibaca');
    }
    abort(403);
}

public function markAllAsRead()
{
    $user = auth()->user();
    $user->notifikasis()->where('dibaca', false)->update(['dibaca' => true]);

    return back()->with('success', 'Semua notifikasi berhasil ditandai sudah dibaca');
}
public function updateStatus($id, $status)
{
    $pesanan = Pemesanan::findOrFail($id);
    $pesanan->status = $status;
    $pesanan->save();

    // Tentukan pesan notifikasi berdasarkan status
    $pesan = match($status) {
        'terverifikasi' => "Pesanan kamu telah diverifikasi oleh admin.",
        'dibatalkan' => "Pesanan kamu telah dibatalkan oleh admin.",
        'ditolak' => "Pesanan kamu ditolak. Silakan hubungi admin.",
        'sudah_diserahkan' => "Mobil dari pesanan kamu telah diserahkan.",
        'sudah_dikembalikan' => "Pengembalian mobil kamu telah diverifikasi.",
        default => "Status pesanan kamu diperbarui.",
    };

    Notifikasi::create([
        'user_id' => $pesanan->user_id,
        'pesan' => "Pesanan ID {$pesanan->id}: {$pesan}",
        'tipe' => $status,
    ]);

    return redirect()->back()->with('success', "Status pesanan diperbarui menjadi '{$status}' dan notifikasi dikirim.");
}

public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();
    return back()->with('success', 'Pengguna berhasil dihapus.');
}

public function toggleBlock($id)
{
    $user = User::findOrFail($id);
    $user->is_blocked = !$user->is_blocked;
    $user->save();
    return back()->with('success', $user->is_blocked ? 'Pengguna berhasil diblokir.' : 'Blokir pengguna telah dibuka.');
}


}
