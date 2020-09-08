<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_record', function (Blueprint $table) {
            $table->unsignedBigInteger('attendance_id');
            $table->unsignedBigInteger('academic_class_student_id');

            $table->foreign('attendance_id')
                ->references('id')
                ->on('attendances')
                ->onDelete('cascade');
            $table->foreign('academic_class_student_id')
                ->references('id')
                ->on('academic_class_students')
                ->onDelete('cascade');

            $table->index(['attendance_id', 'academic_class_student_id']);
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
        Schema::dropIfExists('attendance_record');
    }
}
