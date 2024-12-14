<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'carts';
    protected $fillable = [
        'user_id',
        'produk_id',
        'quantity'];


    // Relasi ke tabel User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tabel Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
