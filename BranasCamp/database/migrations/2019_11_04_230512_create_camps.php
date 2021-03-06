<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCamps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->date('campStart');
            $table->date('campEnd');
            $table->dateTime('registrationOpen');
            $table->dateTime('registrationCloses');
            $table->integer('participantSpots');
            $table->integer('leaderSpots');
            $table->boolean('active')->unique();
            $table->tinyInteger('open')->nullable();
            $table->tinyInteger('late_open')->nullable();
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
        Schema::dropIfExists('camps');
    }
}
