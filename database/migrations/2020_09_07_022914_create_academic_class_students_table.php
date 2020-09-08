<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAcademicClassStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academic_class_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('academic_class_id');
            $table->unsignedBigInteger('student_id');
            $table->integer('number');

            $table->foreign('academic_class_id')
                ->references('id')
                ->on('academic_classes')
                ->onDelete('cascade');
            $table->foreign('student_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('academic_class_students');
    }
}
