<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDisplayTypeToRulesets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rulesets', function (Blueprint $table) {
            $table->string('display_type')->default('dropdown')->comment('dropdown,swatch,grid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rulesets', function (Blueprint $table) {
            //
        });
    }
}
