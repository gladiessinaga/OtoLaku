<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;   
use App\Models\Pemesanan;

class AdminPemesananController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::with('user', 'mobil')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('admin.pemesanan.index', compact('pemesanan'));
    }

    public function show($id)
    {
        $pemesanan = Pemesanan::with('user', 'mobil')->findOrFail($id);
        return view('admin.pemesanan.detail', compact('pemesanan'));
    }
 
    public function verifikasi($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status = 'terverifikasi';
        $pemesanan->save();

        // Kirim notifikasi ke user nanti di sini

        return redirect()->back()->with('success', 'Pemesanan berhasil diverifikasi.');
    }

    public function destroy($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    $pemesanan->delete();

    return redirect()->route('admin.pemesanan.index')->with('success', 'Pemesanan berhasil dihapus.');
}

public function setujuiPembatalan($id) {
    $p = Pemesanan::findOrFail($id);
    $p->status = 'dibatalkan';
    $p->status_pembatalan = 'disetujui';
    $p->save();

    // Tambahkan notifikasi atau email jika perlu
    return back()->with('success', 'Pemesanan berhasil dibatalkan.');
}

public function tolakPembatalan($id) {
    $p = Pemesanan::findOrFail($id);
    $p->status_pembatalan = 'ditolak';
    $p->save();

    return back()->with('success', 'Permintaan pembatalan ditolak.');
}

   
}
