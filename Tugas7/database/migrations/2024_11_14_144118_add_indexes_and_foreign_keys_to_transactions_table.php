<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->index('transaction_id');
            $table->index('order_id');
            $table->index('transaction_status');

        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['transaction_id']);
            $table->dropIndex(['order_id']);
            $table->dropIndex(['transaction_status']);

        });
    }
};
