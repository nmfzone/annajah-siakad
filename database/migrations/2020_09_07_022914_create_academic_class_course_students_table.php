<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicClassCourseStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_class_course_students', function (Blueprint $table) {
            $table->id();
            $table->integer('number');

            $table->foreignId('academic_class_course_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->constrained('users')
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
        Schema::dropIfExists('academic_class_course_students');
    }
}
