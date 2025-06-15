<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembatalan;
use App\Models\Pemesanan;
use App\Models\User;
use App\Notifications\PembatalanDisetujui;
use App\Notifications\PembatalanDitolak;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PemesananDibatalkan;



class PembatalanController extends Controller
{
    public function store(Request $request, $pemesanan_id)
{
    $request->validate([
        'alasan' => 'required',
        'alasan_lain' => 'nullable|string|max:255',
    ]);

    $pemesanan = Pemesanan::findOrFail($pemesanan_id);

    // Cek apakah sudah ada pembatalan
    if ($pemesanan->pembatalan) {
        return back()->with('error', 'Pembatalan sudah diajukan.');
    }

    Pembatalan::create([
        'pemesanan_id' => $pemesanan->id,
        'alasan' => $request->alasan,
        'alasan_lain' => $request->alasan === 'Lainnya' ? $request->alasan_lain : null,
        'status' => 'pending',
    ]);

    // Kirim notifikasi ke admin (bisa lebih dari satu admin)
    $adminUsers = \App\Models\User::where('role', 'admin')->get();
    foreach ($adminUsers as $admin) {
        $admin->notify(new \App\Notifications\PembatalanMasukNotification($pembatalan));
    }

    return redirect()->route('user.riwayat')->with('success', 'Permintaan pembatalan dikirim.');
}

public function approve($id)
{
    $pembatalan = Pembatalan::findOrFail($id);
    $pembatalan->status = 'disetujui';
    $pembatalan->save();

    $pemesanan = $pembatalan->pemesanan; // pastikan relasi sudah ada di model Pembatalan
    $pemesanan->status = 'dibatalkan';
    $pemesanan->save();

    $pemesanan->user->notify(new PembatalanDisetujui($pembatalan));


    return redirect()->back()->with('success', 'Pembatalan pesanan berhasil disetujui.');
}

public function reject($id)
{
    $pembatalan = Pembatalan::findOrFail($id);
    $pembatalan->status = 'ditolak';
    $pembatalan->save();

    $pemesanan = $pembatalan->pemesanan;
    $pemesanan->user->notify(new PembatalanDitolak());

    $pembatalan->pemesanan->user->notify(new PembatalanDitolak($pembatalan->pemesanan));

    return redirect()->back()->with('success', 'Pembatalan pesanan berhasil ditolak.');
}

public function setujui($id)
{
    $pembatalan = Pembatalan::findOrFail($id);
    $pembatalan->status = 'disetujui';
    $pembatalan->save();

    // Kirim notifikasi ke user terkait pemesanan
    // dd($user->name, $user->id);
    $user = $pembatalan->pemesanan->user; // pastikan relasi benar
    $user->notify(new PembatalanDisetujui($pembatalan));

    return redirect()->back()->with('success', 'Pembatalan telah disetujui dan notifikasi dikirim.');
}

public function batalkan(Request $request, $id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    // Update status pemesanan
    $pemesanan->status = 'dibatalkan';
    $pemesanan->save();

    // Ambil semua user dengan role admin
    $admins = User::where('role', 'admin')->get();

    // Kirim notifikasi ke semua admin
    foreach ($admins as $admin) {
        $admin->notify(new PemesananDibatalkan($pemesanan));
    }

    return redirect()->back()->with('success', 'Pemesanan dibatalkan dan admin telah diberi tahu.');
}
}