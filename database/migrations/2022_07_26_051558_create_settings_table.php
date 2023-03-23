<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title');
            $table->string('meta_description');
            $table->string('meta_keywords')->nullable();
            $table->string('site_email');
            $table->string('site_phone_number')->nullable();
            $table->longText('address')->nullable();
            $table->string('google_analytics')->nullable();
            $table->string('maintenance_mode');
            $table->string('maintenance_mode_title')->nullable();
            $table->longText('maintenance_mode_content')->nullable();
            $table->string('copyright');
            $table->longText('summary')->nullable();
            $table->longText('about')->nullable();
            $table->enum('admin_approval',[0,1])->default('0');
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
        Schema::dropIfExists('settings');
    }
}
