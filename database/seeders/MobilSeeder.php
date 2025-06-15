<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mobil;


class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mobil::create([
            'nama' => 'Avanza',
            'deskripsi' => '2018.',
            'harga' => 350000,
            'foto' => 'avanza.jpg',
            'fasilitas' => 'AC, WiFi, Charger'
        ]);

        Mobil::create([
        'nama' => 'Avanza',
        'deskripsi' => 'Tahun 2018',
        'harga' => 350000,
        'foto' => 'brio.jpg',
        'fasilitas' => 'AC, USB Port'
    ]);

        Mobil::create([
            'nama' => 'Ertiga',
            'deskripsi' => 'suzuki.',
            'harga' => 400000,
            'foto' => 'xenia.jpg',
            'fasilitas' => 'AC, GPS, Charger'
    ]);

        Mobil::create([
            'nama' => 'suzuki xl 7',
            'deskripsi' => 'tahun 2018',
            'harga' => 400000,
            'foto' => 'xenia.jpg',
            'fasilitas' => 'AC, GPS, Charger'
    ]);
    
        Mobil::create([
            'nama' => 'Avanza',
            'deskripsi' => 'tahun 2023.',
            'harga' => 400000,
            'foto' => 'xenia.jpg',
            'fasilitas' => 'AC, GPS, Charger'
    ]);
    
        Mobil::create([
            'nama' => 'innova reborn',
            'deskripsi' => 'berbahan bakar solar',
            'harga' => 600000,
            'foto' => 'xenia.jpg',
            'fasilitas' => 'AC, GPS, Charger'
    ]);
        Mobil::create([
            'nama' => 'innova reborn',
            'deskripsi' => 'berbahan bakar bensin',
            'harga' => 500000,
            'foto' => 'xenia.jpg',
            'fasilitas' => 'AC, GPS, Charger'
    ]);
    
        Mobil::create([
            'nama' => 'Pajero Sport',
            'deskripsi' => 'tahun 2018.',
            'harga' =>'1000000',
            'foto' => 'xenia.jpg',
            'fasilitas' => 'AC, GPS, Charger'
    ]);
    
        Mobil::create([
            'nama' => 'Avanza',
            'deskripsi' => 'tahun 2018.',
            'harga' => 350000,
            'foto' => 'xenia.jpg',
            'fasilitas' => 'AC, GPS, Charger'
    ]);
    
    Mobil::create([
            'nama' => 'Avanza',
            'deskripsi' => 'tahun 2018.',
            'harga' => 350000,
            'foto' => 'xenia.jpg',
            'fasilitas' => 'AC, GPS, Charger'
    ]);
    }
}
