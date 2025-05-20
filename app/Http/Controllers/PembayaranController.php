<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pembayaran;
use App\Models\Mobil;

class PembayaranController extends Controller
{
    public function show($pemesananId)
    {
        $pemesanan = Pemesanan::with('mobil')->findOrFail($pemesananId);

        // Jika ingin ambil data pembayaran juga (optional)
        $pembayaran = Pembayaran::where('pemesanan_id', $pemesananId)->first();

        return view('user.pembayaran', compact('pemesanan', 'pembayaran'));
    }

    public function konfirmasi(Request $request, Pemesanan $pemesanan)
    {
        $validated = $request->validate([
            'metode' => 'required|in:transfer,ewallet,cod',
            'bukti_transfer' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bukti_ewallet' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti_transfer')) {
            $buktiPath = $request->file('bukti_transfer')->store('bukti_pembayaran', 'public');
        } elseif ($request->hasFile('bukti_ewallet')) {
            $buktiPath = $request->file('bukti_ewallet')->store('bukti_pembayaran', 'public');
        }

        Pembayaran::create([
            'pemesanan_id' => $pemesanan->id,
            'metode' => $validated['metode'],
            'status' => $validated['metode'] === 'cod' ? 'verified' : 'pending',
            'bukti_pembayaran' => $buktiPath,
            'jumlah' => $pemesanan->mobil->harga * $pemesanan->durasi,
        ]);

        $pemesanan->update([
            'status' => 'menunggu_verifikasi',
            'metode_pembayaran' => $validated['metode'],
            'bukti_pembayaran' => $buktiPath,
        ]);

        return redirect()->route('pembayaran.selesai', $pemesanan->id)
                         ->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function create(Pemesanan $pemesanan)
    {
        return view('user.pembayaran.konfirmasi', compact('pemesanan'));
    }

    public function simpan(Request $request)
{
    $validated = $request->validate([
        'mobil_id' => 'required|exists:mobils,id',
        'tanggal_sewa' => 'required|date',
        'durasi' => 'required|integer|min:1',
        'dengan_supir' => 'required|boolean',
        'pengambilan' => 'required|string',
        'metode_pembayaran' => 'required|in:transfer,ewallet,cod',
        'ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'sim' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $ktpPath = $request->file('ktp')->store('ktp', 'public');
    $simPath = $request->file('sim')->store('sim', 'public');

    // Ambil mobil
    $mobil = Mobil::findOrFail($validated['mobil_id']);

    // Hitung total
    $hargaMobil = $mobil->harga;
    $totalHarga = $hargaMobil * $validated['durasi'];
    if ($validated['dengan_supir']) {
        $totalHarga += 200000;
    }

    // Simpan ke pemesanan
    $pemesanan = Pemesanan::create([
        'user_id' => auth()->id(),
        'mobil_id' => $validated['mobil_id'],
        'tanggal_sewa' => $validated['tanggal_sewa'],
        'durasi' => $validated['durasi'],
        'dengan_supir' => $validated['dengan_supir'],
        'pengambilan' => $validated['pengambilan'],
        'ktp' => $ktpPath,
        'sim' => $simPath,
        'total_harga' => $totalHarga,
        'status' => 'menunggu_verifikasi',
        'metode_pembayaran' => $validated['metode_pembayaran'],
    ]);

    // Simpan ke pembayaran
    Pembayaran::create([
        'pemesanan_id' => $pemesanan->id,
        'metode' => $validated['metode_pembayaran'],
        'status' => $validated['metode_pembayaran'] === 'cod' ? 'verified' : 'pending',
        'jumlah' => $totalHarga,
    ]);

    return redirect()->route('pembayaran.selesai', $pemesanan->id)
                     ->with('success', 'Pembayaran dan pemesanan berhasil disimpan.');
}

public function selesai($id)
{
    $pemesanan = Pemesanan::findOrFail($id);
    return view('user.pembayaran-selesai', compact('pemesanan'));
}



}
