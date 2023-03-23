<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bulks', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('bulk_type');
            $table->foreign('user_id', 'user_fk_806119772')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bulks', function (Blueprint $table) {
            //
        });
    }
};
