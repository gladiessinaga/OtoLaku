<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faq;


class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'question' => 'Apa yang harus saya lakukan jika mobil mogok?',
            'answer' => 'Segera gunakan fitur Lapor Masalah dan hubungi admin.'
        ]);

        Faq::create([
            'question' => 'Bagaimana cara membatalkan pesanan?',
            'answer' => 'Masuk ke halaman Riwayat Pemesanan, lalu klik tombol "Batalkan" dan isi alasan.'
        ]);
    }
}
