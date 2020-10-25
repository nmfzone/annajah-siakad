<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('provider')->nullable();
            $table->string('provider_holder_name')->nullable();
            $table->string('provider_number')->nullable();
            $table->string('fraud_status')->nullable();
            $table->mediumText('payment_proof_file')->nullable();
            $table->timestamp('paid_on');
            $table->foreignId('invoice_id')
                ->constrained()
                ->onDelete('cascade');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
