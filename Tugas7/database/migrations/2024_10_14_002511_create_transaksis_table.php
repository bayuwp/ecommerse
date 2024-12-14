<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->decimal('total_harga', 10, 2);
            $table->text('deskripsi')->nullable();
            $table->string('nomer_invoice');
            $table->enum('status_pembayaran', ['pending', 'selesai', 'dibatalkan']);
            $table->timestamp('tanggal_pembelian');
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};
