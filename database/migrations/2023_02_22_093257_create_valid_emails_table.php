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
        Schema::create('valid_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->enum('is_valid_email',[0,1,2,3,4,5])->default(0);
            $table->enum('verification_method',['dashboard','api','csv','task'])->nullable(true);
            $table->string('process_time')->nullable();
            $table->string('email_score')->nullable();
            $table->enum('is_syntax_check',[0,1])->default(0);
            $table->enum('is_disposable',[0,1])->default(0);
            $table->enum('is_free_email',[0,1])->default(0);
            $table->enum('is_domain',[0,1])->default(0);
            $table->enum('is_mx_record',[0,1])->default(0);
            $table->enum('is_smtp_valid',[0,1])->default(0);
            $table->enum('is_username',[0,1])->default(0);
            $table->enum('is_catch_all',[0,1])->default(0);
            $table->enum('is_role',[0,1])->default(0);
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
        Schema::dropIfExists('valid_emails');
    }
};
