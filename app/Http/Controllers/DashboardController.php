<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Pemesanan;

class DashboardController extends Controller
{
    // Landing page
    public function landing()
    {
        // ambil mobil terbatas, misal 3
        $mobils = Mobil::take(3)->get();

        // kirim data ke view dashboard.blade.php
        return view('dashboard', compact('mobils'))
               ->with('page', 'landing');
    }

     public function adminDashboard()
    {
        $mobils = Mobil::all();
        $jumlahPemesananBaru = Pemesanan::where('status', 'menunggu_verifikasi')->count();

        return view('admin.dashboard', compact('mobils', 'jumlahPemesananBaru'))->with('page', 'admin');
    }

    public function userDashboard()
    {
        $mobilTersedia = Mobil::where('status', 'tersedia')->get();
    return view('user.dashboard', compact('mobilTersedia'));
    }

    public function index() {
        $jumlahPemesananBaru = Pemesanan::where('status', 'menunggu_verifikasi')->count();
        return view('admin.dashboard', compact('jumlahPemesananBaru'));
    }

     // Tambahkan method ini untuk riwayat pemesanan user
    public function riwayat()
    {
        $user = Auth::user();
        $pemesanan = Pemesanan::with('mobil')
                        ->where('user_id', $user->id)
                        ->latest()
                        ->get();

        return view('user.riwayat', compact('pemesanan'));
    }

}
