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
    ];

    /**
     * Mendefinisikan relasi banyak ke satu dengan model Kategori.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id'); // Menyatakan bahwa 'kategori_id' adalah foreign key
    }

    /**
     * Mendefinisikan relasi satu ke banyak dengan model Transaksi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'produk_id'); // Menyatakan bahwa 'produk_id' adalah foreign key
    }
}
