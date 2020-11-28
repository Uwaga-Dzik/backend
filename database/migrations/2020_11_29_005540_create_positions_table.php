<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->double('latitude');
            $table->double('longitude');
            $table->string('country')->nullable();
            $table->string('voivodeship')->nullable();
            $table->string('subregion')->nullable();
            $table->string('disctrict')->nullable();
            $table->string('city')->nullable();
            $table->string('street')->nullable();
            $table->unsignedBigInteger("report_id");
            $table->foreign("report_id")->references('id')->on('reports')->onDelete('cascade');
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
        Schema::dropIfExists('positions');
    }
}
