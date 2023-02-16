<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePriceToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->biginteger('price_prop')->change();
            $table->biginteger('price_land')->change();
            $table->biginteger('jigyuo_area_cost')->change();
            $table->biginteger('debt')->change();
            $table->biginteger('jigyuo_debt')->change();
            $table->biginteger('jigyuo_kentiku_fee')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
}
