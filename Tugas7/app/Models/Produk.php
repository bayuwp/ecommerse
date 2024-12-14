<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $fillable = [
        'kategori_id',
        'nama',
        'harga',
        'foto_produk',
        'deskripsi',
        'sold', // Tambahkan kolom sold
    ];
    /**
     * Mendefinisikan relasi banyak ke satu dengan model Kategori.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Mendefinisikan relasi satu ke banyak dengan model Transaksi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'produk_id');
    }
}

