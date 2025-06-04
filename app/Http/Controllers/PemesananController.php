<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemesanan;
use Carbon\Carbon;
use App\Models\Pembatalan;
use App\Notifications\VerifikasiPembayaranNotification;
use Barryvdh\DomPDF\Facade\Pdf;

class PemesananController extends Controller
{

// public function create($id)
// {
//     $mobil = Mobil::findOrFail($id);
//     return view('user.form-pemesanan', compact('mobil'));
// }

public function store(Request $request, Mobil $mobil)
{
    // dd($request->all());
    $validated = $request->validate([
        'tanggal_sewa' => 'required|date|after_or_equal:today',
        'durasi' => 'required|integer|min:1',
        'opsi_sopir' => 'required',
        'pengambilan' => 'required',
        'alamat_pengantaran' => $request->pengambilan === 'diantar' ? 'required|string' : 'nullable|string',
        'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'sim' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        // 'no_hp'    => ['required', 'regex:/^08[0-9]{8,11}$/'],
    ], 
);

    // Hitung tanggal selesai
    $tanggalMulai = \Carbon\Carbon::parse($validated['tanggal_sewa']);
    $tanggalSelesai = $tanggalMulai->copy()->addDays($validated['durasi'] - 1);

    // Cek apakah mobil sudah dipesan di rentang tanggal itu
    $mobilSudahDipesan = Pemesanan::where('mobil_id', $mobil->id)
        ->whereIn('status', ['menunggu_verifikasi', 'terverifikasi']) // status aktif
        ->where(function ($query) use ($tanggalMulai, $tanggalSelesai) {
            $query->whereBetween('tanggal_sewa', [$tanggalMulai, $tanggalSelesai])
                  ->orWhereRaw('? BETWEEN tanggal_sewa AND DATE_ADD(tanggal_sewa, INTERVAL durasi - 1 DAY)', [$tanggalMulai])
                  ->orWhereRaw('? BETWEEN tanggal_sewa AND DATE_ADD(tanggal_sewa, INTERVAL durasi - 1 DAY)', [$tanggalSelesai]);
        })
        ->exists();

    if ($mobilSudahDipesan) {
        return back()->with('error', 'Mobil tidak tersedia di tanggal yang dipilih.');
    }

    // Simpan file
    $ktpPath = $request->file('ktp')->store('ktp', 'public');
    $simPath = $request->file('sim')->store('sim', 'public');

    // Simpan ke database
    $pemesanan = Pemesanan::create([
        'user_id' => auth()->id(),
        'mobil_id' => $mobil->id,
        'tanggal_sewa' => $validated['tanggal_sewa'],
        'durasi' => $validated['durasi'],
        'opsi_sopir' => $validated['opsi_sopir'],
        'pengambilan' => $validated['pengambilan'],
        'alamat_pengantaran' => data_get($validated, 'alamat_pengantaran'),   
        'ktp' => $ktpPath,
        'sim' => $simPath,
        // 'no_hp' => $validated['no_hp'], 
        'status' => 'draft',
        'tanggal_sewa_terakhir' => $tanggalSelesai->format('Y-m-d'),
    ]); 

    session([
        'pemesanan_data' => array_merge(
            $request->except(['ktp', 'sim']),
            ['ktp_path' => $ktpPath, 'sim_path' => $simPath]
        )
    ]);

    return redirect()->route('pembayaran.konfirmasi', $pemesanan->id);
}


public function pembayaranSelesai($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    $pemesanan->status = 'selesai'; // <-- mungkin perlu ini
    $pemesanan->save();

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
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }
    
    $pemesanan = Pemesanan::findOrFail($id);
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
    $pemesanans = Pemesanan::with('mobil')
        ->where('user_id', $user->id)
        ->whereIn('status', ['selesai', 'dibatalkan', 'dikembalikan']) // ← tambahkan ini
        ->orderByDesc('created_at')
        ->get();

    return view('user.riwayat.index', compact('pemesanans'));
}

// Method detail riwayat pemesanan selesai (jika ingin pisah)
public function showRiwayat($id)
{
    $user = Auth::user();
    $pemesanans = Pemesanan::with('mobil')
               ->where('user_id', $user->id)
               ->where('id', $id)
               ->where('status', 'selesai')
               ->firstOrFail();

    return view('user.riwayat.detail', compact('pemesanans'));
}

public function index()
{
    $pemesanan = Pemesanan::with('mobil')
                ->where('user_id', auth()->id())
                ->get();

    return view('user.pemesanan.index', compact('pemesanan'));
}

public function batalkan(Request $request, $id) {
    $request->validate([
        'alasan' => 'required|string',
        'alasan_lain' => 'nullable|string',
    ]);

    $pemesanan = Pemesanan::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

    // Cek status agar hanya bisa batalkan jika status masih valid untuk dibatalkanad
    if (!in_array($pemesanan->status, ['menunggu_verifikasi', 'terverifikasi'])) {
        return redirect()->back()->with('error', 'Pemesanan tidak dapat dibatalkan.');
    }

    if ($pemesanan->pembatalan) {
    return redirect()->back()->with('error', 'Permintaan pembatalan sudah dikirim.');
}
    Pembatalan::create([
    'pemesanan_id' => $pemesanan->id,
    'alasan' => $request->alasan === 'Lainnya' ? $request->alasan_lain : $request->alasan,
    'status' => 'pending',
]);

    return redirect()->back()->with('success', 'Permintaan pembatalan telah dikirim. Menunggu persetujuan admin.');
}

public function form(Mobil $mobil)
{
    // Ambil semua pemesanan aktif (yang belum dibatalkan/ditolak) untuk mobil ini
    $pemesananAktif = Pemesanan::where('mobil_id', $mobil->id)
        ->whereIn('status', ['menunggu_verifikasi', 'terverifikasi'])
        ->get();

    // Kumpulkan semua tanggal yang terisi
    $tanggalTerisi = [];

    foreach ($pemesananAktif as $pemesanan) {
    $start = Carbon::parse($pemesanan->tanggal_sewa);
    $end = $start->copy()->addDays($pemesanan->durasi - 1);
    $pemesanan->tanggal_sewa_terakhir = $end->format('Y-m-d');
    $pemesanan->save();

    for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
        $tanggalTerisi[] = $date->format('Y-m-d');
    }
}
    return view('user.form-pemesanan', compact('mobil', 'tanggalTerisi'));
}

public function konfirmasiPengembalian($id)
{
    $pemesanan = Pemesanan::findOrFail($id);

    if ($pemesanan->status !== 'sudah_diambil') {
        return redirect()->back()->with('error', 'Status pemesanan tidak valid untuk pengembalian.');
    }

    $pemesanan->status = 'dikembalikan';
    $pemesanan->save();

    return redirect()->back()->with('success', 'Status berhasil diubah menjadi Dikembalikan.');
}

public function ajukanPengembalian($id)
{
    $pemesanan = Pemesanan::findOrFail($id);

    // Pastikan mobil sudah diserahkan
    if ($pemesanan->status_penyerahan !== 'sudah_diserahkan') {
        return back()->with('error', 'Mobil belum diserahkan.');
    }

    // Cegah pengajuan berulang
    if ($pemesanan->status_pengembalian === 'menunggu_verifikasi') {
        return back()->with('error', 'Pengembalian sudah diajukan.');
    }

    // Update status pengembalian
    $pemesanan->status_pengembalian = 'menunggu_verifikasi';
    $pemesanan->save();

    return back()->with('success', 'Pengajuan pengembalian berhasil.');
}


public function downloadInvoice($id)
{
    $pemesanan = Pemesanan::with('mobil')->findOrFail($id);

    $user = Auth::user();

    if ($pemesanan->status !== 'terverifikasi') {
        return redirect()->back()->with('error', 'Invoice hanya tersedia untuk pesanan yang terverifikasi.');
    }


    $pdf = Pdf::loadView('user.invoice', compact('pemesanan', 'user'));
    return $pdf->download('invoice_pemesanan_'.$pemesanan->id.'.pdf');
}

public function uploadPerjanjian(Request $request, $id)
{
    $request->validate([
        'file_perjanjian' => 'required|mimes:pdf|max:2048',
    ]);

    $pemesanan = Pemesanan::findOrFail($id);
    $file = $request->file('file_perjanjian')->store('perjanjian_sewa', 'public');

    $pemesanan->file_perjanjian = $file;
    $pemesanan->status_perjanjian = 'Diupload';
    $pemesanan->save();

    return back()->with('success', 'Perjanjian berhasil diupload!');
}


}