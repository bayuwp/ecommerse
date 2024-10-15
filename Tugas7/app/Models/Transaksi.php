<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database
    protected $table = 'transaksi';

    // Menentukan kolom yang dapat diisi
    protected $fillable = [
        'pelanggan_id',
        'total_harga',
        'produk_id',
        'deskripsi',
        'nomer_invoice',
        'status_pembayaran',
        'tanggal_pembelian',
        'tanggal_pembayaran',
    ];

    /**
     * Mendefinisikan relasi banyak ke satu dengan model Pelanggan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id'); // Menyatakan bahwa 'pelanggan_id' adalah foreign key
    }

    /**
     * Mendefinisikan relasi banyak ke satu dengan model Produk.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id'); // Menyatakan bahwa 'produk_id' adalah foreign key
    }
}
