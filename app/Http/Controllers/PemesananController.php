<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;

class PemesananController extends Controller
{

// public function create($id)
// {
//     $mobil = Mobil::findOrFail($id);
//     return view('user.form-pemesanan', compact('mobil'));
// }

public function form(Mobil $mobil)
{
    return view('user.form-pemesanan', compact('mobil'));
}

public function store(Request $request, Mobil $mobil)
{
    $validated = $request->validate([
        'tanggal_sewa' => 'required|date',
        'durasi' => 'required|integer|min:1',
        'opsi_sopir' => 'required',
        'pengambilan' => 'required',
        'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'sim' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    $ktpPath = $request->file('ktp')->store('ktp', 'public');
    $simPath = $request->file('sim')->store('sim', 'public');

    $pemesanan = Pemesanan::create([
        'user_id' => auth()->id(),
        'mobil_id' => $mobil->id,
        'tanggal_sewa' => $validated['tanggal_sewa'],
        'durasi' => $validated['durasi'],
        'opsi_sopir' => $validated['opsi_sopir'],
        'pengambilan' => $validated['pengambilan'],
        'ktp' => $ktpPath,
        'sim' => $simPath,
        'status' => 'menunggu', // status default
    ]);


    // Simpan pemesanan ke database (buat model Pemesanan jika perlu)
    // Pemesanan::create([...]);

    session([
    'pemesanan_data' => array_merge(
        $request->except(['ktp', 'sim']),
        ['ktp_path' => $ktpPath, 'sim_path' => $simPath]
    )
]);
    return redirect()->route('pembayaran.konfirmasi',  $pemesanan->id);
}

public function pembayaranSelesai($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    return view('user.pembayaran-selesai', compact('pemesanan'));
}   

    public function show($id)
{
    // dd('masuk show');    
    $user = Auth::user();
    $pemesanan = Pemesanan::with('mobil')
               ->where('user_id', Auth::id())
               ->where('id', $id)
               ->firstOrFail();  // ambil 1 data

return view('user.pemesanan.detail', compact('pemesanan'));

}

public function tolak($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    // Update status jadi 'ditolak'
    $pemesanan->status = 'ditolak';
    $pemesanan->save();

    return redirect()->route('admin.pemesanan.show', $id);

}

// Method untuk daftar pemesanan aktif (menunggu, terverifikasi, dibatalkan)
public function aktif()
{
    $user = Auth::user();
    $pemesanan = Pemesanan::with('mobil')
        ->where('user_id', $user->id)
        ->whereIn('status', ['menunggu_verifikasi', 'terverifikasi', 'dibatalkan'])
        ->latest()
        ->get();

    return view('user.pemesanan.detail', compact('pemesanan'));
}

// Method untuk riwayat pemesanan selesai
public function riwayat()
{
    $user = Auth::user();
    $pemesanan = Pemesanan::with('mobil')
        ->where('user_id', $user->id)
        ->where('status', 'selesai')
        ->latest()
        ->get();

    return view('user.riwayat.index', compact('pemesanan'));
}

// Method detail riwayat pemesanan selesai (jika ingin pisah)
public function showRiwayat($id)
{
    $user = Auth::user();
    $pemesanan = Pemesanan::with('mobil')
               ->where('user_id', $user->id)
               ->where('id', $id)
               ->where('status', 'selesai')
               ->firstOrFail();

    return view('user.riwayat.detail', compact('pemesanan'));
}

public function index()
{
    $pemesanan = Pemesanan::with('mobil')
                ->where('user_id', auth()->id())
                ->get();

    return view('user.pemesanan.index', compact('pemesanan'));
}

public function batalkan(Request $request, $id) {
    $pemesanan = Pemesanan::findOrFail($id);
    
    $pemesanan->permintaan_pembatalan = true;
    $pemesanan->alasan_pembatalan = $request->alasan == 'Lainnya' ? $request->alasan_lain : $request->alasan;
    $pemesanan->status_pembatalan = 'pending';
    $pemesanan->save();

    return back()->with('success', 'Permintaan pembatalan telah dikirim ke admin.');
}



}
