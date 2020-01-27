<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisplaySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('display_settings', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->primary('id');
            $table->integer('shop_id')->unsigned()->nullable();
            $table->string('display_type')->nullable();
            $table->string('style_final_string')->nullable();
            $table->json('type')->nullable();
            $table->json('text_settings')->nullable();
            $table->json('style_settings')->nullable();
            $table->json('button_settings')->nullable();
            $table->timestamps();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('display_settings');
    }
}
