<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesetProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruleset_products', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->primary('id');
            $table->uuid('ruleset_id')->nullable();
            $table->string('product_id')->nullable();
            $table->string('product_title')->nullable();
            $table->string('product_handle')->nullable();
            $table->string('product_img_src')->nullable();
            $table->timestamps();
            $table->foreign('ruleset_id')->references('id')->on('rulesets')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ruleset_products');
    }
}
