<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;

class AdminPengembalianController extends Controller
{
    public function verifikasi($id)
{
    $pemesanan = Pemesanan::findOrFail($id);

    $pemesanan->update([
        'sudah_dikembalikan' => true,
        'tanggal_pengembalian' => now(),
    ]);

    return redirect()->back()->with('success', 'Pengembalian mobil telah diverifikasi.');
}

public function index()
{
    $pemesananS = Pemesanan::where('status', 'diserahkan')
        ->where('sudah_dikembalikan', false)
        ->with('user', 'mobil')
        ->latest()
        ->get();

        dd($pemesananS);
    return view('admin.pengembalian', compact('pemesananS'));
}

public function verifikasiPengembalian($id)
{
    $pemesanan = Pemesanan::findOrFail($id);

    // Update status dan kolom sudah_dikembalikan
    $pemesanan->sudah_dikembalikan = true;
    $pemesanan->status = 'dikembalikan';
    $pemesanan->tanggal_pengembalian = now();
    $pemesanan->save();

    return redirect()->back()->with('success', 'Mobil telah berhasil diverifikasi pengembaliannya.');
}

}
