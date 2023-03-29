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
        Schema::create('benefit_package', function (Blueprint $table) {
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id', 'package_id_fk_8249275')->references('id')->on('packages')->onDelete('cascade');
            $table->unsignedBigInteger('benefit_id');
            $table->foreign('benefit_id', 'benefit_id_fk_8249275')->references('id')->on('benefits')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
