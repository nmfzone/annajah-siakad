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
            $table->boolean('late')->default(false);

            $table->foreignId('attendance_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('academic_class_course_student_id')
                ->constrained()
                ->onDelete('cascade');

            $table->index(['attendance_id', 'academic_class_course_student_id'], 'attendance_record_1');
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
