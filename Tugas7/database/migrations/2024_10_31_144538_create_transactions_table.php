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
            Schema::create('transactions', function (Blueprint $table) {
                $table->id();
                $table->integer('transaction_id')->nullable(false);
                $table->string('order_id', 100)->nullable(false);
                $table->string('payment_type', 100)->nullable();
                $table->integer('gross_amount')->nullable(false);
                $table->timestamp('transaction_time')->nullable();
                $table->enum('transaction_status', ['pending', 'settlement', 'cancel', 'expire'])->nullable(false);
                $table->text('metadata')->nullable();
                $table->timestamps();
            });
        }


        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('transactions');
        }
    };
