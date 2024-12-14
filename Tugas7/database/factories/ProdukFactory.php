<?php

namespace Database\Factories;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    protected $model = Produk::class;

    public function definition()
    {
        // Ambil semua ID dari kategori yang ada
        $kategoriIds = Kategori::pluck('id')->toArray();

        // Pastikan ada kategori untuk dipilih, ambil ID kategori secara acak
        $kategoriId = $this->faker->randomElement($kategoriIds);

        return [
            'kategori_id' => $kategoriId, // Pastikan kategori_id ada
            'nama' => $this->faker->word(),
            'harga' => $this->faker->randomFloat(2, 1000, 100000),
            'foto_produk' => $this->faker->imageUrl(640, 480, 'product'),
            'deskripsi' => $this->faker->sentence(),
        ];
    }
}
