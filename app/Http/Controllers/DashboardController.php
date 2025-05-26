<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\VerifikasiPembayaranNotification;

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

    // Ambil notifikasi belum dibaca tanpa langsung menandainya sudah dibaca
    $unreadNotifications = $user->unreadNotifications;

    // dd($unreadNotifications);

    return view('user.dashboard', compact('mobilTersedia', 'pemesananUser', 'pemesananTerbaru', 'unreadNotifications'));
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

    public function notifikasi()
{
    $user = Auth::user();
    $notifications = $user->notifications()->latest()->get();

     // Tandai semua notif unread jadi read
    $user->unreadNotifications->markAsRead();

    return view('user.notifikasi', compact('notifications'));
}



}
