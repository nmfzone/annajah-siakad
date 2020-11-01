<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->string('no_kk')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('graduated_at')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_address')->nullable();
            $table->string('father_job')->nullable();
            $table->integer('father_salary')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_address')->nullable();
            $table->string('mother_job')->nullable();
            $table->integer('mother_salary')->nullable();
            $table->string('wali_name')->nullable();
            $table->string('wali_phone')->nullable();
            $table->string('wali_address')->nullable();
            $table->string('wali_job')->nullable();
            $table->integer('wali_salary')->nullable();
            $table->string('previous_school')->nullable();
            $table->string('previous_school_type')->nullable();
            $table->string('previous_school_address')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
