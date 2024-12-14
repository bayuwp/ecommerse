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
            $table->string('nama')->unique();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('nama');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategoris');
    }
}
