<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');

            $table->index('country_id', 'country_cities_country_idx');
            $table->index('city_id', 'country_cities_city_idx');

            $table->foreign('country_id', 'country_cities_country_fk')->on('countries')->onUpdate('cascade')->onDelete('cascade')->references('id');
            $table->foreign('city_id', 'country_cities_city_fk')->on('cities')->onUpdate('cascade')->onDelete('cascade')->references('id');

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
        Schema::dropIfExists('country_cities');
    }
}
