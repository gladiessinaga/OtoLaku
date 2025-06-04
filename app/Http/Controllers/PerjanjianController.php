<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PerjanjianController extends Controller
{
    public function generatePdf()
    {
        $data = [
            'tanggal_sewa'      => date('d-m-Y'),
            'nama_pemilik'      => 'Budi Santoso',
            'alamat_pemilik'    => 'Jl. Merdeka No.10, Jakarta',
            'telepon_pemilik'   => '081234567890',
            'nama_penyewa'      => 'Andi Wijaya',
            'nik_penyewa'       => '3276123456789012',
            'alamat_penyewa'    => 'Jl. Sudirman No. 5, Jakarta',
            'telepon_penyewa'   => '089876543210',
            'merk_tipe'         => 'Toyota Avanza',
            'nomor_polisi'      => 'B 1234 XYZ',
            'warna'             => 'Putih',
            'tahun'             => '2020',
            'tanggal_mulai'     => '01-06-2025',
            'tanggal_selesai'   => '05-06-2025',
            'biaya_sewa'        => 1500000,
            'biaya_sewa_terbilang' => 'Satu Juta Lima Ratus Ribu',
            'denda_per_hari'    => 100000,
            'tanggal_ttd'       => date('d-m-Y'),
        ];

        $pdf = PDF::loadView('pdf.perjanjian-sewa', $data);

        return $pdf->download('Perjanjian_Sewa_Mobil_'.date('Ymd').'.pdf');
    }

    public function upload(Request $request)
{
    $request->validate([
        'file_perjanjian' => 'required|mimes:pdf|max:2048',
    ]);

    $path = $request->file('file_perjanjian')->store('perjanjian', 'public');

    FilePerjanjian::create([
        'user_id' => auth()->id(), // sesuaikan kalau pakai relasi ke user
        'file_path' => $path,
    ]);

    return back()->with('success', 'File berhasil diupload dan disimpan.');
}
}
