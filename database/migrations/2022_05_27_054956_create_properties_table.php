<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name',128);
            $table->string('address',128)->nullable();
            $table->string('category',128)->nullable();
            // $table->date('open_date',128)->nullable();
            // $table->date('start_date',128)->nullable();
            $table->float('land_area')->nullable();
            $table->string('ground',128)->nullable();
            $table->string('city_planning',128)->nullable();
            $table->string('use_district',128)->nullable();
            $table->float('building_coverage_ratio')->nullable();
            $table->float('floor_area_ratio')->nullable();
            $table->text('text')->nullable();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('properties');
    }
}
