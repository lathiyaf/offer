<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesetSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruleset_settings', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->primary('id');
            $table->uuid('ruleset_id')->nullable();
            $table->integer('get')->nullable();
            $table->integer('buy')->nullable();
            $table->string('offer_type')->nullable();
            $table->timestamps();
            $table->foreign('ruleset_id')->references('id')->on('rulesets')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruleset_settings');
    }
}
