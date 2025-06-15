<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;


class UserDendaController extends Controller
{
    public function formPembayaranBBM($id)
    {
        $pemesanan = Pemesanan::with('mobil')->findOrFail($id);

        if (!$pemesanan->denda_bbm || $pemesanan->denda_bbm <= 0) {
            return redirect()->route('dashboard')->with('error', 'Tidak ada denda BBM untuk pemesanan ini.');
        }

        return view('user.bayar-denda-bbm', compact('pemesanan'));
    }

    public function prosesPembayaranBBM(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:Transfer Bank,E-Wallet,COD',
            'bukti_bbm' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

    $pemesanan = Pemesanan::findOrFail($id);
    
        if ($request->hasFile('bukti_bbm')) {
        $path = $request->file('bukti_bbm')->store('bukti-bbm', 'public');
        $pemesanan->bukti_bbm = $path;
        }

        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->status_verifikasi_denda_bbm = 'sudah_dibayar';
        $pemesanan->metode_pembayaran_denda = $request->metode_pembayaran;
        $pemesanan->save();
    
        return redirect()->route('user.dashboard')->with('success', 'Pembayaran denda BBM berhasil dikonfirmasi.');
    }
}
