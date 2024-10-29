<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategoris = DB::table('kategoris')->get();

        foreach ($kategoris as $kategori) {
            echo 'Nama: ' . $kategori->nama . ', Keterangan: ' . $kategori->keterangan . PHP_EOL;
        }
    }
}
