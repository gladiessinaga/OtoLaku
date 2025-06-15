<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Penyerahan;
use App\Notifications\VerifikasiPembayaranNotification;


class AdminPenyerahanController extends Controller
{
    public function index()
    {
        $pemesananSiapDiserahkan = Pemesanan::with('mobil', 'user')
            ->where('status', 'terverifikasi')
            ->where('status_penyerahan', 'belum_diserahkan') // mobil siap diserahkan
            ->get();
        
        $pemesananBelumVerifikasi = Pemesanan::with('mobil', 'user')
            ->where('status', '!=', 'terverifikasi')
            ->get();

        $pemesananSudahDiserahkan = Pemesanan::with('mobil', 'user')
            ->where('status', 'terverifikasi')
            ->where('status_penyerahan', 'sudah_diserahkan') // mobil sudah diserahkan
            ->get();

        $pemesananS = Pemesanan::with('mobil', 'user')
            ->where('status_pengembalian', 'menunggu_verifikasi') 
            ->where('status_penyerahan', 'sudah_dikembalikan') 
            ->get();

        return view('admin.penyerahan', compact(
            'pemesananSiapDiserahkan',
            'pemesananBelumVerifikasi',
            'pemesananSudahDiserahkan',
            'pemesananS'
        ));
    }

    // Update status penyerahan mobil menjadi sudah diserahkan
    public function update($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->status_penyerahan === 'sudah_diserahkan') {
            return redirect()->back()->with('success', 'Mobil sudah pernah diserahkan sebelumnya.');
        }

        $pemesanan->status_penyerahan = 'sudah_diserahkan';
        $pemesanan->save();

        return redirect()->back()->with('success', 'Status penyerahan diperbarui.');
    }

    // Fungsi untuk verifikasi pengembalian mobil oleh admin
    public function verifikasiPengembalian($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        if ($pemesanan->status_pengembalian !== 'menunggu_verifikasi') {
            return redirect()->back()->with('error', 'Status pengembalian tidak bisa diverifikasi.');
        }

        $pemesanan->status_pengembalian = 'sudah_diverifikasi';
        $pemesanan->status = 'selesai'; // misal status selesai setelah pengembalian diverifikasi
        $pemesanan->save();

        return redirect()->back()->with('success', 'Pengembalian mobil berhasil diverifikasi.');
    }

    public function serahkan($id)
{
    // Cari pemesanan berdasarkan ID
    $pemesanan = Pemesanan::findOrFail($id);

    // Update status pemesanan menjadi "sudah diserahkan"
    $pemesanan->status_penyerahan = 'sudah_diserahkan';  // atau sesuai status yang kamu gunakan
    $pemesanan->save();

    // Redirect kembali dengan pesan sukses
    return redirect()->back()->with('success', 'Mobil berhasil ditandai sudah diserahkan.');
}


}

