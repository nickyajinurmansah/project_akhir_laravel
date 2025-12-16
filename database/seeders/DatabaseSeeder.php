<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat User Admin
        \App\Models\User::factory()->create([
            'name' => 'Admin Tapastay',
            'email' => 'admin@tapastay.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        // Buat 2 Layanan
        Service::create([
            'name' => 'Kamar Deluxe Ocean View',
            'price' => 500000,
            'description' => 'Kamar mewah pemandangan laut'
        ]);

        Service::create([
            'name' => 'Ruang Meeting VIP',
            'price' => 1000000,
            'description' => 'Kapasitas 20 orang'
        ]);
    }
}
