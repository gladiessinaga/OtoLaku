<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mobil; 
use App\Models\Pemesanan;


class PemesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user dan mobil contoh
        $user = User::first(); // pastikan sudah ada user
        $mobil = Mobil::first(); // pastikan sudah ada mobil

        if (!$user || !$mobil) {
            $this->command->info('Seeder Pemesanan butuh data user dan mobil dulu.');
            return;
        }

        // Buat folder 'public/uploads' kalau belum ada
        Storage::disk('public')->makeDirectory('uploads');

        // Simulasi upload file KTP dan SIM (gunakan file dummy atau copy file asli jika mau)
        // Kalau kamu belum ada file dummy, kamu bisa skip dulu bagian ini
        $ktpPath = 'uploads/ktp_dummy.jpg';
        $simPath = 'uploads/sim_dummy.jpg';

        // Pastikan file dummy ada di storage/app/public/uploads/
        // Kalau belum ada, bisa kamu buat manual file dummy itu, atau kosongin saja field ktp dan sim.

        Pemesanan::create([
            'user_id' => $user->id,
            'mobil_id' => $mobil->id,
            'tanggal_sewa' => now()->addDays(5)->format('Y-m-d'),
            'durasi' => 3,
            'opsi_sopir' => 'dengan',
            'metode_pembayaran' => 'transfer',
            'pengambilan' => 'antar',
            'ktp' => $ktpPath,
            'sim' => $simPath,
            'status' => 'pending',
        ]);
    }
}
