<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Menentukan nama tabel di database
    protected $table = 'pelanggan';

    // Menentukan kolom yang dapat diisi
    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'email',
        'nomer_hp',
        'alamat',
        'foto_profil',
    ];

    /**
     * Mendefinisikan relasi satu ke banyak dengan model Transaksi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id'); // Menyatakan bahwa 'pelanggan_id' adalah foreign key
    }
}
