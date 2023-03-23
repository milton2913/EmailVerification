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
        Schema::create('bulks', function (Blueprint $table) {
            $table->id();
            $table->string('name',250);
            $table->enum('bulk_type',['Task','CSV','API']);
            $table->enum('status',['Process','Completed','Failed'])->default('Process');
            $table->integer('total')->default(0);
            $table->float('progress')->default(0);
            $table->string('run_time')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('bulks');
    }
};
