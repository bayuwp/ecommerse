<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database
    protected $table = 'transactions'; // Pastikan nama tabel sesuai dengan migrasi

    // Menentukan kolom yang dapat diisi
    protected $fillable = [
        'transaction_id',
        'order_id',
        'payment_type',
        'gross_amount',
        'transaction_time',
        'transaction_status',
        'metadata',
        'pelanggan_id', // Tambahkan ini
        'produk_id',    // Tambahkan ini
    ];

    /**
     * Mendefinisikan relasi banyak ke satu dengan model Pelanggan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id'); // Ganti dengan kolom foreign key yang sesuai jika ada
    }

    /**
     * Mendefinisikan relasi banyak ke satu dengan model Produk.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id'); // Ganti dengan kolom foreign key yang sesuai jika ada
    }
}
