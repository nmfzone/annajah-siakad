<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserAndSiteToMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('uuid')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('site_id')
                ->nullable()
                ->after('uuid')
                ->constrained()
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
        Schema::table('media', function (Blueprint $table) {
            if (DB::getDriverName() != 'sqlite') {
                $table->dropForeign(['user_id']);
            }

            $table->dropColumn('user_id');
        });

        Schema::table('media', function (Blueprint $table) {
            if (DB::getDriverName() != 'sqlite') {
                $table->dropForeign(['site_id']);
            }

            $table->dropColumn('site_id');
        });
    }
}
