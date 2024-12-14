<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('pelanggan_id')->nullable(); // Menambahkan kolom pelanggan_id
            $table->unsignedBigInteger('produk_id')->nullable(); // Menambahkan kolom produk_id

            // Jika Anda ingin mengatur foreign key
            $table->foreign('pelanggan_id')->references('id')->on('pelanggan')->onDelete('cascade');
            $table->foreign('produk_id')->references('id')->on('produk')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['pelanggan_id']);
            $table->dropForeign(['produk_id']);
            $table->dropColumn(['pelanggan_id', 'produk_id']);
        });
    }
};
