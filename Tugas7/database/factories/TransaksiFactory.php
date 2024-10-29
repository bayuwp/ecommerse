<?php

namespace Database\Factories;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransaksiFactory extends Factory
{
    protected $model = Transaksi::class;

    public function definition()
    {
        return [
            'produk_id' => Produk::inRandomOrder()->first()->id,
            'pelanggan_id' => Pelanggan::inRandomOrder()->first()->id,
            'jumlah' => $this->faker->numberBetween(1, 10),
            'total_harga' => $this->faker->numberBetween(10000, 100000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
