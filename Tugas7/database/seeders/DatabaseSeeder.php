<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menambahkan pengguna dummy
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Menjalankan seeder untuk kategori, produk, dan transaksi
        $this->call([
            \Database\Seeders\KategoriSeeder::class,
            \Database\Seeders\ProdukSeeder::class,
            \Database\Seeders\TransaksiSeeder::class,
        ]);
    }
}
