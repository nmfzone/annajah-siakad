<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('payment_type');
            $table->string('provider')->nullable();
            $table->string('provider_number')->nullable();
            $table->string('provider_holder_name')->nullable();
            $table->string('redirect_url')->nullable();
            $table->float('amount')->default(0);
            $table->string('status');
            $table->timestamp('valid_until')->useCurrent();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
