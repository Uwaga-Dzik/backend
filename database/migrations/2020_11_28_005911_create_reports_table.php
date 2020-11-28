<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('size')->comment("0 - small, 1 - medium, 2 - large")->nullable();
            $table->boolean("with_children")->nullable();
            $table->boolean("alive")->nullable();
            $table->boolean("is_tracks")->default(0)->comment("0 - boar, 1 - tracks");
            $table->text("description")->nullable();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('reports');
    }
}
