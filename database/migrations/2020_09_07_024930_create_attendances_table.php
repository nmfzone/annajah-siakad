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
            $table->string('type');
            $table->string('name');
            $table->unsignedBigInteger('academic_class_id');
            $table->boolean('is_open')->default(false);
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->useCurrent();
            $table->timestamp('advanced_started_at')->nullable();
            $table->timestamp('advanced_ended_at')->nullable();
            $table->text('message')->nullable();

            $table->foreign('academic_class_id')
                ->references('id')
                ->on('academic_classes')
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
        Schema::dropIfExists('attendances');
    }
}
