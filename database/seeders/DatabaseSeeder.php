<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; //  ini untuk akses model User
use Illuminate\Support\Facades\Hash; // ini untuk enkripsi password


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // Buat admin
    User::updateOrCreate(
    ['email' => 'admin@example.com'], // cari berdasarkan email
    [
        'name' => 'Admin Rental',
        'password' => Hash::make('password123'),
        'role' => 'admin',
    ]
);

    User::updateOrCreate(
        ['email' => 'user@example.com'], 
        [
            'name' => 'User Penyewa',
            'password' => Hash::make('password123'),
            'role' => 'user',
        ]
    );

        $this->call([
        MobilSeeder::class,
        FaqSeeder::class,
    ]);
    
    }
}
