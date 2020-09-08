<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('type');
            $table->string('name');
            $table->unsignedBigInteger('academic_class_id');
            $table->boolean('is_open')->default(false);
            $table->timestamp('started_at');
            $table->timestamp('ended_at');
            $table->text('message')->nullable();

            $table->foreign('academic_class_id')
                ->references('id')
                ->on('academic_classes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
