<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCartsTableAddForeignKeys extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            // Hapus foreign key yang lama jika ada
            $table->dropForeign(['user_id']);
            $table->dropForeign(['produk_id']);

            // Definisikan ulang foreign key untuk kolom user_id dan produk_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            // Menghapus foreign key jika rollback
            $table->dropForeign(['user_id']);
            $table->dropForeign(['produk_id']);
        });
    }
}
