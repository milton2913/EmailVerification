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
        Schema::create('bulk_valid_email', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bulk_id');
            $table->foreign('bulk_id', 'bulk_id_fk_222023')->references('id')->on('bulks')->onDelete('cascade');
            $table->unsignedBigInteger('valid_email_id');
            $table->foreign('valid_email_id', 'valid_email_id_fk_222023')->references('id')->on('valid_emails')->onDelete('cascade');
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
        Schema::dropIfExists('bulk_valid_email');
    }
};
