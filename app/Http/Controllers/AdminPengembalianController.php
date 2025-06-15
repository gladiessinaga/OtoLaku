<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Carbon\Carbon;
use App\Models\Pengembalian;
use App\Models\Mobil;

class AdminPengembalianController extends Controller
{
    public function verifikasi($id)
{
    $pemesanan = Pemesanan::findOrFail($id);

    $pemesanan->update([
        'sudah_dikembalikan' => true,
        'tanggal_pengembalian' => now(),
        'status_pengembalian' => 'Sudah Dikembalikan',
    ]);

    return redirect()->back()->with('success', 'Pengembalian mobil telah diverifikasi.');
}

// public function index()
//     {
//         $pemesanans = Pemesanan::with(['user', 'mobil'])
//             ->where('status_pengembalian', 'pending') // sesuaikan kondisi
//             ->get();

//         return view('admin.verifikasi-pengembalian', compact('pemesanans'));
//     }

public function verifikasiPengembalian()
{
    $today = Carbon::today()->toDateString();
    // $pemesanans = Pemesanan::whereDate('tanggal_sewa_terakhir', '<=', $today)
    //               ->where('status_pengembalian', 'Belum Dikembalikan')
    //               ->get();
    // $pemesanans = Pemesanan::all();

    $pemesanans = Pemesanan::where('status_pengembalian', 'Belum Dikembalikan')->get();

    // $pemesanans = Pemesanan::where('status_pengembalian', 'Belum Dikembalikan')
    // ->where('tanggal_sewa_terakhir', '<=', Carbon::today())
    // ->get();

    //  dd($pemesanans);
    $hasilVerifikasi = Pemesanan::whereNotNull('kondisi_bbm_kembali')->get();


    

    return view('admin.verifikasi-pengembalian', compact('pemesanans', 'hasilVerifikasi'));
}

public function prosesVerifikasi(Request $request, $id)
{
    $request->validate([
        'kondisi_bbm_kembali' => 'required|in:Penuh,Setengah,Hampir Habis',
        'denda_bbm' => 'nullable|integer|min:0',
    ]);

    $pemesanan = Pemesanan::findOrFail($id);

    $pemesanan->update([
        'sudah_dikembalikan' => true,
        'tanggal_pengembalian' => now(),
        'status_pengembalian' => 'Sudah Dikembalikan',
        'kondisi_bbm_kembali' => $request->kondisi_bbm_kembali, 
        'denda_bbm' => $request->denda_bbm ?? 0,
    ]);

    // Tambahkan ke tabel pengembalian
    Pengembalian::create([
        'pemesanan_id' => $pemesanan->id,
        'status_pengembalian' => 'diterima',
        'kondisi_bbm_kembali' => $request->kondisi_bbm_kembali,
        'denda_bbm' => $request->denda_bbm ?? 0,
    ]);

    return redirect()->route('admin.verifikasi-pengembalian')->with('success', 'Verifikasi pengembalian berhasil.');
}

public function halamanVerifikasi()
{
    $pemesanans = Pemesanan::with('user', 'mobil')
                    ->where('status_pengembalian', 'Belum Dikembalikan')
                    ->get();

    $hasilVerifikasi = Pemesanan::with('user', 'mobil')
                    ->where('status_pengembalian', 'Sudah Dikembalikan')
                    ->get();

    return view('admin.verifikasi-pengembalian', compact('pemesanans', 'hasilVerifikasi'));
}

public function dendaBBM()
{
    $pemesanans = Pemesanan::with('user', 'mobil')
        ->where('denda_bbm', '>', 0)
        ->where('status_verifikasi_denda_bbm', '!=', 'diverifikasi')
        ->get();

    return view('admin.denda-bbm', compact('pemesanans'));
}

public function verifikasiDendaBBM($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    $pemesanan->status_verifikasi_denda_bbm = 'diverifikasi';
    $pemesanan->save();

    return redirect()->back()->with('success', 'Denda BBM berhasil diverifikasi.');
}



}
