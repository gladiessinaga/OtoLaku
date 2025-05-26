<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;   
use App\Models\Pemesanan;
use App\Models\Pembatalan;
use App\Notifications\PembatalanDitolak;
use App\Models\User;
use App\Notifications\VerifikasiPembayaranNotification;
use Carbon\Carbon;

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

        $user = User::find($pemesanan->user_id);
        $user->notify(new VerifikasiPembayaranNotification($pemesanan));

        return redirect()->back()->with('success', 'Pemesanan berhasil diverifikasi.');
    }

    public function destroy($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    $pemesanan->delete();

    return redirect()->route('admin.pemesanan.index')->with('success', 'Pemesanan berhasil dihapus.');
}

public function setujuiPembatalan($id) {
    $pembatalan = Pemesanan::findOrFail($id);
    $pembatalan->status = 'dibatalkan';
    $pembatalan->save();

    // Update status pembatalan di tabel pembatalans
    $pembatalan = Pembatalan::where('pemesanan_id', $id)->first();
    if ($pembatalan) {
        $pembatalan->status = 'disetujui';
        $pembatalan->save();
    }
    
    // Tambahkan notifikasi atau email jika perlu
    return back()->with('success', 'Pemesanan berhasil dibatalkan.');
}

public function tolakPembatalan($id) {
    $pembatalan = Pembatalan::where('pemesanan_id', $p->id)->first();
if ($pembatalan) {
    $pembatalan->status = 'ditolak';
    $pembatalan->save();
}

    return back()->with('success', 'Permintaan pembatalan ditolak.');
}

public function terimaKembali($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    if ($pemesanan->status === 'ditolak') {
        $pemesanan->status = 'terverifikasi';
        $pemesanan->save();
    }

    return redirect()->route('admin.pemesanan.index', $id)->with('success', 'Pesanan berhasil diterima kembali.');
}

public function pembatalanIndex()
{
    $pembatalans = Pembatalan::with(['pemesanan.user', 'pemesanan.mobil'])->where('status', 'pending')->get();
    return view('admin.pembatalan', compact('pembatalans'));
}

public function tolak($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    $pemesanan->status = 'ditolak';
    $pemesanan->save();

    // Jika perlu, kirim notifikasi ke user terkait
    $pemesanan->user->notify(new PembatalanDitolak($pemesanan));

    return redirect()->route('admin.pemesanan.index')->with('success', 'Pesanan berhasil ditolak.');
}

public function indexPengembalian()
{
    $today = Carbon::today();

    $pemesananMenungguVerifikasi = Pemesanan::with('user', 'mobil')
    ->where('status_penyerahan', 'sudah_diserahkan') // mobil sudah diserahkan ke user
    // ->whereDate('tanggal_pengembalian', '<=', $today)
    ->where('status_pengembalian', 'menunggu_verifikasi', false)
    ->where('sudah_dikembalikan', false)
    ->get();

        dd($pemesananMenungguVerifikasi);

    return view('admin.pengembalian.index', [
        'pemesananS' => $pemesananMenungguVerifikasi,
        // data lain jika perlu
    ]);
}

public function verifikasiPengembalian($id)
{
    $pemesanan = Pemesanan::findOrFail($id);

    // Update status dan flag sudah_dikembalikan
    $pemesanan->sudah_dikembalikan = true;
    $pemesanan->status = 'selesai';  // ganti status sesuai logikamu
    $pemesanan->save();

    // Bisa juga kirim notifikasi ke user (optional)

    return redirect()->back()->with('success', 'Pengembalian mobil berhasil diverifikasi.');
}


   
}
