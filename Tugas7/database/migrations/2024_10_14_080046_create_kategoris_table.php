<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategorisTable extends Migration
{
    public function up()
    {
        Schema::create('kategoris', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique(); // Tambahkan unique jika ingin mencegah duplikat
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Tambahkan indeks untuk kolom nama jika diperlukan
            $table->index('nama');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategoris');
    }
}
