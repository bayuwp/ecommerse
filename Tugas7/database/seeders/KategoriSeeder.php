<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        DB::table('kategoris')->insert([
            ['nama' => 'sepatu', 'keterangan' => 'Kategori untuk semua jenis sepatu'],
            ['nama' => 'baju', 'keterangan' => 'Kategori untuk berbagai jenis baju'],
            ['nama' => 'celana', 'keterangan' => 'Kategori untuk berbagai jenis celana'],
        ]);
    }
}
