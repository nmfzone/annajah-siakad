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
            $table->timestamp('graduated_at')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_address')->nullable();
            $table->integer('father_salary')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('mother_address')->nullable();
            $table->integer('mother_salary')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->string('previous_school')->nullable();
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
