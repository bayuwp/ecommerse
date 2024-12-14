<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('produk', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['kategori_id']);

            // Tambahkan foreign key baru yang merujuk ke tabel 'kategoris'
            $table->foreign('kategori_id')->references('id')->on('kategoris')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('produk', function (Blueprint $table) {
            // Hapus foreign key yang merujuk ke 'kategoris'
            $table->dropForeign(['kategori_id']);

            // Tambahkan kembali foreign key yang merujuk ke tabel 'kategori'
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
        });
    }
};
