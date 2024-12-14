<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori; // Pastikan model sudah di-import

class KategoriSeeder extends Seeder
{
    public function run()
    {
        // Tambahkan data kategori
        $kategoris = [
            ['id' => 1, 'nama' => 'Sepatu'],
            ['id' => 2, 'nama' => 'Baju'],
            ['id' => 3, 'nama' => 'Celana'],
            ['id' => 4, 'nama' => 'Tas'],
        ];

        // Masukkan data ke database
        foreach ($kategoris as $kategori) {
            Kategori::updateOrCreate(['id' => $kategori['id']], $kategori);
        }
    }
}

